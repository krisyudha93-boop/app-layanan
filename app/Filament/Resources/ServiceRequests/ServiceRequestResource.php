<?php

namespace App\Filament\Resources\ServiceRequests;

use App\Enums\ApprovalDecision;
use App\Enums\MinistryDecision;
use App\Enums\PbiReason;
use App\Enums\ServiceHandler;
use App\Enums\ServiceRequestStatus;
use App\Filament\Resources\ServiceRequests\Pages\CreateServiceRequest;
use App\Filament\Resources\ServiceRequests\Pages\EditServiceRequest;
use App\Filament\Resources\ServiceRequests\Pages\ListServiceRequests;
use App\Filament\Resources\ServiceRequests\Pages\ViewServiceRequest;
use App\Models\Approval;
use App\Models\District;
use App\Models\Disposition;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\PbiReactivation;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use App\Services\PdfService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string | \UnitEnum | null $navigationGroup = 'Layanan Sosial';

    protected static ?string $navigationLabel = 'Pengajuan Layanan (Tiket)';

    protected static ?string $modelLabel = 'Pengajuan Layanan';

    protected static ?string $pluralModelLabel = 'Pengajuan Layanan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'request_number';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pemohon')
                    ->description('Identitas warga pemohon layanan')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('applicant_name')
                                ->label('Nama Lengkap Pemohon')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('applicant_nik')
                                ->label('NIK Pemohon (16 Digit)')
                                ->required()
                                ->length(16)
                                ->numeric(),
                            TextInput::make('family_card_number')
                                ->label('Nomor Kartu Keluarga (KK)')
                                ->required()
                                ->length(16)
                                ->numeric(),
                            TextInput::make('phone')
                                ->label('Nomor WhatsApp / HP Aktif')
                                ->tel()
                                ->required()
                                ->maxLength(20),
                            Select::make('district_id')
                                ->label('Kecamatan Domisili')
                                ->options(District::pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set) => $set('village_id', null))
                                ->dehydrated(false)
                                ->afterStateHydrated(function ($component, $record) {
                                    if ($record && $record->village) {
                                        $component->state($record->village->district_id);
                                    }
                                }),
                            Select::make('village_id')
                                ->label('Desa / Kelurahan')
                                ->options(function (callable $get) {
                                    $districtId = $get('district_id');
                                    if (!$districtId) {
                                        return Village::pluck('name', 'id');
                                    }
                                    return Village::where('district_id', $districtId)->pluck('name', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap (RT/RW, Dusun/Jalan)')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Jenis Layanan')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('service_type_id')
                                ->label('Pilih Jenis Layanan')
                                ->relationship('serviceType', 'name', fn ($q) => $q->where('is_active', true))
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->required(),
                            Toggle::make('is_priority')
                                ->label('Tandai Prioritas / Darurat Medis')
                                ->helperText('Pengajuan prioritas akan tampil paling atas di antrean petugas')
                                ->default(false),
                        ]),
                    ]),

                // SECTION KHUSUS: LAYANAN 1 (SK DTSEN)
                Section::make('Detail Khusus: Surat Keterangan DTSEN')
                    ->relationship('dtsenCertificate')
                    ->visible(fn (callable $get) => 
                        ServiceType::find($get('service_type_id'))?->handler === ServiceHandler::DTSEN
                    )
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('dtsen_purpose_id')
                                ->label('Tujuan Penggunaan Surat')
                                ->options(DtsenPurpose::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                            TextInput::make('relationship_to_applicant')
                                ->label('Hubungan dengan Pemohon')
                                ->placeholder('Contoh: Diri Sendiri, Anak Kandung, Orang Tua')
                                ->default('Diri Sendiri')
                                ->required(),
                            TextInput::make('subject_name')
                                ->label('Nama Orang yang Diterangkan')
                                ->placeholder('Nama calon siswa / penerima')
                                ->required(),
                            TextInput::make('subject_nik')
                                ->label('NIK Orang yang Diterangkan')
                                ->length(16)
                                ->numeric()
                                ->required(),
                        ]),
                        Textarea::make('purpose_description')
                            ->label('Keterangan Keperluan / Nama Sekolah / Kampus')
                            ->placeholder('Contoh: Persyaratan SPMB SMAN 1 Talun Jalur Afirmasi')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                // SECTION KHUSUS: LAYANAN 2 (REAKTIVASI PBI-JK)
                Section::make('Detail Khusus: Reaktivasi KIS / PBI-JK')
                    ->relationship('pbiReactivation')
                    ->visible(fn (callable $get) => 
                        ServiceType::find($get('service_type_id'))?->handler === ServiceHandler::PBI
                    )
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('participant_name')
                                ->label('Nama Peserta BPJS')
                                ->required(),
                            TextInput::make('participant_nik')
                                ->label('NIK Peserta')
                                ->length(16)
                                ->numeric()
                                ->required(),
                            TextInput::make('bpjs_card_number')
                                ->label('Nomor Kartu BPJS / KIS (13 Digit)')
                                ->required(),
                            DatePicker::make('deactivated_date')
                                ->label('Perkiraan Tanggal Nonaktif')
                                ->nullable(),
                            Select::make('reason')
                                ->label('Alasan Reaktivasi')
                                ->options([
                                    PbiReason::CHRONIC->value => PbiReason::CHRONIC->label(),
                                    PbiReason::CATASTROPHIC->value => PbiReason::CATASTROPHIC->label(),
                                    PbiReason::EMERGENCY->value => PbiReason::EMERGENCY->label(),
                                    PbiReason::NEWBORN->value => PbiReason::NEWBORN->label(),
                                    PbiReason::OTHER->value => PbiReason::OTHER->label(),
                                ])
                                ->required(),
                            TextInput::make('health_facility_name')
                                ->label('Nama Faskes / RS Perujuk')
                                ->placeholder('Contoh: RSUD Ngudi Waluyo Wlingi')
                                ->nullable(),
                            TextInput::make('health_letter_number')
                                ->label('Nomor Surat Keterangan Medis')
                                ->nullable(),
                        ]),
                    ]),

                Section::make('Dokumen Persyaratan')
                    ->description('Unggah berkas KTP, KK, dan dokumen pendukung sesuai persyaratan')
                    ->schema([
                        Repeater::make('documents')
                            ->relationship('documents')
                            ->schema([
                                Select::make('service_requirement_id')
                                    ->label('Jenis Dokumen')
                                    ->options(function (callable $get) {
                                        $typeId = $get('../../service_type_id');
                                        if (!$typeId) {
                                            return \App\Models\ServiceRequirement::pluck('name', 'id');
                                        }
                                        return \App\Models\ServiceRequirement::where('service_type_id', $typeId)->pluck('name', 'id');
                                    })
                                    ->required(),
                                FileUpload::make('file_path')
                                    ->label('Pilih Berkas')
                                    ->disk('local')
                                    ->directory('service_documents')
                                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                    ->maxSize(5120)
                                    ->required(),
                                TextInput::make('notes')
                                    ->label('Catatan Berkas')
                                    ->placeholder('Keterangan berkas')
                                    ->nullable(),
                            ])
                            ->columns(3)
                            ->defaultItems(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('request_number')
            ->defaultSort('submitted_at', 'desc')
            ->columns([
                TextColumn::make('request_number')
                    ->label('Nomor Tiket')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                TextColumn::make('applicant_name')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->description(fn (ServiceRequest $record) => 'NIK: ' . $record->applicant_nik),

                TextColumn::make('serviceType.name')
                    ->label('Layanan')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('village.name')
                    ->label('Wilayah')
                    ->description(fn (ServiceRequest $record) => 'Kec. ' . $record->village?->district?->name),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ServiceRequest $record) => $record->status?->color() ?? 'gray')
                    ->formatStateUsing(fn ($state) => $state instanceof ServiceRequestStatus ? $state->label() : ($state ? ServiceRequestStatus::tryFrom($state)?->label() ?? $state : '-')),

                IconColumn::make('is_priority')
                    ->label('Prioritas')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedExclamationCircle)
                    ->trueColor('danger')
                    ->falseIcon(null),

                TextColumn::make('officer.name')
                    ->label('Petugas PJ')
                    ->placeholder('Belum Ditugaskan')
                    ->toggleable(),

                TextColumn::make('submitted_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Layanan')
                    ->options(collect(ServiceRequestStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
                SelectFilter::make('service_type_id')
                    ->relationship('serviceType', 'name')
                    ->label('Jenis Layanan'),
                TernaryFilter::make('is_priority')
                    ->label('Hanya Prioritas'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // ACTION: DISPOSISI PETUGAS
                Action::make('disposisi')
                    ->label('Disposisi')
                    ->icon(Heroicon::OutlinedArrowsRightLeft)
                    ->color('primary')
                    ->form([
                        Select::make('work_unit_id')
                            ->label('Unit Kerja Tujuan')
                            ->options(WorkUnit::where('is_active', true)->pluck('name', 'id'))
                            ->required(),
                        Select::make('officer_id')
                            ->label('Petugas Pelaksana')
                            ->options(User::role(['petugas_dinsos', 'administrator'])->pluck('name', 'id'))
                            ->nullable(),
                        Textarea::make('instructions')
                            ->label('Instruksi Disposisi')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $record->update([
                            'work_unit_id' => $data['work_unit_id'],
                            'officer_id' => $data['officer_id'] ?? $record->officer_id,
                        ]);

                        Disposition::create([
                            'dispositionable_type' => ServiceRequest::class,
                            'dispositionable_id' => $record->id,
                            'from_user_id' => auth()->id() ?? 1,
                            'to_work_unit_id' => $data['work_unit_id'],
                            'to_user_id' => $data['officer_id'] ?? null,
                            'instructions' => $data['instructions'],
                            'disposed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Disposisi Berhasil Dicatat')
                            ->success()
                            ->send();
                    }),

                // ACTION KHUSUS DTSEN: CEK HASIL SIKS-NG
                Action::make('cek_siks_ng')
                    ->label('Cek SIKS-NG')
                    ->icon(Heroicon::OutlinedMagnifyingGlass)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => 
                        $record->serviceType?->handler === ServiceHandler::DTSEN &&
                        in_array($record->status, [
                            ServiceRequestStatus::SUBMITTED,
                            ServiceRequestStatus::DOCUMENT_CHECK,
                            ServiceRequestStatus::DATA_VERIFICATION,
                        ])
                    )
                    ->form([
                        Toggle::make('is_registered')
                            ->label('Terdaftar dalam SIKS-NG / DTSEN?')
                            ->default(true)
                            ->required(),
                        Select::make('decile')
                            ->label('Peringkat Desil Hasil Cek')
                            ->options([
                                1 => 'Desil 1 (Sangat Miskin)',
                                2 => 'Desil 2 (Miskin)',
                                3 => 'Desil 3 (Hampir Miskin)',
                                4 => 'Desil 4 (Rentan Miskin)',
                                5 => 'Desil 5 (Menengah Bawah)',
                                6 => 'Desil 6',
                                7 => 'Desil 7',
                                8 => 'Desil 8',
                                9 => 'Desil 9',
                                10 => 'Desil 10 (Mampu)',
                            ])
                            ->required(),
                        DateTimePicker::make('checked_at')
                            ->label('Waktu Pengecekan')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $cert = $record->dtsenCertificate ?? new DtsenCertificate(['service_request_id' => $record->id]);
                        $cert->is_registered = $data['is_registered'];
                        $cert->decile = $data['decile'];
                        $cert->checked_at = $data['checked_at'];
                        $cert->checker_id = auth()->id() ?? 1;
                        $cert->save();

                        // Business rule check against max_decile
                        $purpose = $cert->purpose;
                        if ($purpose && $data['decile'] > $purpose->max_decile) {
                            Notification::make()
                                ->title('Peringatan: Desil Melebihi Batas Maksimal')
                                ->body("Desil {$data['decile']} melebihi batas maksimal Desil {$purpose->max_decile} untuk {$purpose->name}. Pengajuan dapat ditolak.")
                                ->warning()
                                ->persistent()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Hasil SIKS-NG Berhasil Disimpan')
                                ->success()
                                ->send();
                        }

                        $record->update([
                            'status' => ServiceRequestStatus::DATA_VERIFICATION,
                        ]);
                    }),

                // ACTION: PERSETUJUAN / PARAF BERJENJANG (DTSEN & PBI)
                Action::make('approval_berjenjang')
                    ->label('Paraf / Tanda Tangan')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('warning')
                    ->visible(fn (ServiceRequest $record) => 
                        in_array($record->status, [
                            ServiceRequestStatus::DATA_VERIFICATION,
                            ServiceRequestStatus::ELIGIBILITY_VERIFICATION,
                            ServiceRequestStatus::AWAITING_APPROVAL,
                        ])
                    )
                    ->form([
                        Select::make('step')
                            ->label('Tahap Persetujuan')
                            ->options([
                                1 => 'Tahap 1: Paraf Kepala Bidang (Linjamsos / Rehsos)',
                                2 => 'Tahap 2: Tanda Tangan Final Kepala Dinas Sosial',
                            ])
                            ->default(1)
                            ->required(),
                        Select::make('decision')
                            ->label('Keputusan')
                            ->options([
                                ApprovalDecision::APPROVED->value => 'Disetujui / Diparaf',
                                ApprovalDecision::RETURNED->value => 'Dikembalikan untuk Perbaikan',
                            ])
                            ->default(ApprovalDecision::APPROVED->value)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Catatan Pejabat')
                            ->nullable(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $isDtsen = $record->serviceType?->handler === ServiceHandler::DTSEN;
                        $isPbi = $record->serviceType?->handler === ServiceHandler::PBI;

                        $parentModel = $isDtsen ? $record->dtsenCertificate : ($isPbi ? $record->pbiReactivation : null);

                        if ($parentModel) {
                            Approval::create([
                                'approvable_type' => get_class($parentModel),
                                'approvable_id' => $parentModel->id,
                                'step' => $data['step'],
                                'approver_id' => auth()->id() ?? 1,
                                'decision' => $data['decision'],
                                'notes' => $data['notes'] ?? null,
                                'decided_at' => now(),
                            ]);
                        }

                        if ($data['decision'] === ApprovalDecision::RETURNED->value) {
                            $record->update(['status' => ServiceRequestStatus::REVISION_REQUESTED]);
                            Notification::make()->title('Pengajuan Dikembalikan untuk Perbaikan')->warning()->send();
                            return;
                        }

                        // If Step 2 (Kadis Final)
                        if ((int)$data['step'] === 2) {
                            if ($isDtsen && $record->dtsenCertificate) {
                                $cert = $record->dtsenCertificate;
                                $year = now()->format('Y');
                                $cert->certificate_number = "400.9/{$record->request_number}/409.105/{$year}";
                                $cert->issued_at = now();
                                $cert->signer_id = auth()->id() ?? 1;

                                if ($cert->purpose?->validity_days) {
                                    $cert->valid_until = now()->addDays($cert->purpose->validity_days)->toDateString();
                                }
                                $cert->save();

                                PdfService::generateDtsenCertificatePdf($cert);
                                $record->update(['status' => ServiceRequestStatus::ISSUED]);
                            } elseif ($isPbi && $record->pbiReactivation) {
                                $pbi = $record->pbiReactivation;
                                $year = now()->format('Y');
                                $pbi->recommendation_number = "460/{$record->request_number}/REK-PBI/{$year}";
                                $pbi->recommendation_issued_at = now();
                                $pbi->signer_id = auth()->id() ?? 1;
                                $pbi->save();

                                PdfService::generatePbiRecommendationPdf($pbi);
                                $record->update(['status' => ServiceRequestStatus::RECOMMENDATION_ISSUED]);
                            }
                            Notification::make()->title('Surat Sah Diterbitkan!')->success()->send();
                        } else {
                            $record->update(['status' => ServiceRequestStatus::AWAITING_APPROVAL]);
                            Notification::make()->title('Paraf Tahap 1 Berhasil Dicatat')->success()->send();
                        }
                    }),

                // ACTION KHUSUS PBI: USULKAN KE KEMENSOS
                Action::make('usulkan_kemensos')
                    ->label('Usul ke SIKS-NG Kemensos')
                    ->icon(Heroicon::OutlinedCloudArrowUp)
                    ->color('info')
                    ->visible(fn (ServiceRequest $record) => 
                        $record->serviceType?->handler === ServiceHandler::PBI &&
                        $record->status === ServiceRequestStatus::RECOMMENDATION_ISSUED
                    )
                    ->form([
                        DateTimePicker::make('proposed_to_ministry_at')
                            ->label('Waktu Input Usulan di SIKS-NG')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'proposed_to_ministry_at' => $data['proposed_to_ministry_at'],
                            ]);
                        }
                        $record->update(['status' => ServiceRequestStatus::PROPOSED_TO_MINISTRY]);
                        Notification::make()->title('Usulan Berhasil Dicatat ke Kemensos')->info()->send();
                    }),

                // ACTION KHUSUS PBI: CATAT KEPUTUSAN KEMENSOS
                Action::make('keputusan_kemensos')
                    ->label('Keputusan Kemensos')
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->color('warning')
                    ->visible(fn (ServiceRequest $record) => 
                        $record->serviceType?->handler === ServiceHandler::PBI &&
                        $record->status === ServiceRequestStatus::PROPOSED_TO_MINISTRY
                    )
                    ->form([
                        Select::make('ministry_decision')
                            ->label('Hasil Keputusan Kemensos')
                            ->options([
                                MinistryDecision::APPROVED->value => 'Disetujui Kemensos RI',
                                MinistryDecision::REJECTED->value => 'Ditolak Kemensos RI',
                            ])
                            ->required(),
                        DateTimePicker::make('ministry_decided_at')
                            ->label('Tanggal Keputusan')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $isApproved = $data['ministry_decision'] === MinistryDecision::APPROVED->value;
                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'ministry_decision' => $data['ministry_decision'],
                                'ministry_decided_at' => $data['ministry_decided_at'],
                            ]);
                        }
                        $record->update([
                            'status' => $isApproved ? ServiceRequestStatus::MINISTRY_APPROVED : ServiceRequestStatus::MINISTRY_REJECTED,
                        ]);
                        Notification::make()->title('Keputusan Kemensos Dicatat')->send();
                    }),

                // ACTION KHUSUS PBI: KONFIRMASI AKTIF KEMBALI
                Action::make('konfirmasi_aktif')
                    ->label('Konfirmasi Aktif BPJS')
                    ->icon(Heroicon::OutlinedShieldCheck)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => 
                        $record->serviceType?->handler === ServiceHandler::PBI &&
                        $record->status === ServiceRequestStatus::MINISTRY_APPROVED
                    )
                    ->form([
                        DatePicker::make('reactivated_date')
                            ->label('Tanggal Kepesertaan Aktif Kembali di BPJS Kesehatan')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        if ($record->pbiReactivation) {
                            $record->pbiReactivation->update([
                                'reactivated_date' => $data['reactivated_date'],
                            ]);
                        }
                        $record->update([
                            'status' => ServiceRequestStatus::REACTIVATED,
                            'service_result' => 'Kepesertaan PBI-JK berhasil diaktifkan kembali per ' . $data['reactivated_date'],
                            'completed_at' => now(),
                        ]);
                        Notification::make()->title('Kepesertaan PBI-JK Telah Aktif Kembali!')->success()->send();
                    }),

                // ACTION: UNDUH SALINAN SURAT PDF (DTSEN & PBI)
                Action::make('unduh_surat')
                    ->label('Unduh Surat PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => 
                        ($record->serviceType?->handler === ServiceHandler::DTSEN && in_array($record->status, [ServiceRequestStatus::ISSUED, ServiceRequestStatus::COMPLETED])) ||
                        ($record->serviceType?->handler === ServiceHandler::PBI && in_array($record->status, [ServiceRequestStatus::RECOMMENDATION_ISSUED, ServiceRequestStatus::PROPOSED_TO_MINISTRY, ServiceRequestStatus::MINISTRY_APPROVED, ServiceRequestStatus::REACTIVATED, ServiceRequestStatus::COMPLETED]))
                    )
                    ->url(function (ServiceRequest $record) {
                        if ($record->serviceType?->handler === ServiceHandler::DTSEN && $record->dtsenCertificate) {
                            return route('surat.dtsen.unduh', $record->dtsenCertificate->id);
                        }
                        if ($record->serviceType?->handler === ServiceHandler::PBI && $record->pbiReactivation) {
                            return route('surat.pbi.unduh', $record->pbiReactivation->id);
                        }
                        return '#';
                    })
                    ->openUrlInNewTab(),

                // ACTION: SELESAIKAN PENGAJUAN
                Action::make('selesaikan')
                    ->label('Selesaikan Tiket')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (ServiceRequest $record) => 
                        in_array($record->status, [
                            ServiceRequestStatus::ISSUED,
                            ServiceRequestStatus::REACTIVATED,
                            ServiceRequestStatus::IN_PROCESS,
                        ])
                    )
                    ->form([
                        Textarea::make('service_result')
                            ->label('Hasil Pelayanan Akhir')
                            ->required()
                            ->default('Layanan telah selesai diproses dan dokumen/hasil telah diserahkan.'),
                    ])
                    ->action(function (ServiceRequest $record, array $data) {
                        $record->update([
                            'status' => ServiceRequestStatus::COMPLETED,
                            'service_result' => $data['service_result'],
                            'completed_at' => now(),
                        ]);
                        Notification::make()->title('Tiket Pengajuan Resmi Selesai')->success()->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServiceRequests::route('/'),
            'create' => CreateServiceRequest::route('/create'),
            'view' => ViewServiceRequest::route('/{record}'),
            'edit' => EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
