<?php

namespace App\Filament\Resources\RehabilitationCases;

use App\Enums\HandlingType;
use App\Enums\ReferralStatus;
use App\Enums\RehabilitationCaseStatus;
use App\Filament\Resources\RehabilitationCases\Pages\CreateRehabilitationCase;
use App\Filament\Resources\RehabilitationCases\Pages\EditRehabilitationCase;
use App\Filament\Resources\RehabilitationCases\Pages\ListRehabilitationCases;
use App\Filament\Resources\RehabilitationCases\Pages\ViewRehabilitationCase;
use App\Models\Assessment;
use App\Models\Client;
use App\Models\Complaint;
use App\Models\MonitoringRecord;
use App\Models\Referral;
use App\Models\ReferralInstitution;
use App\Models\RehabilitationCase;
use App\Models\ServiceRequest;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RehabilitationCaseResource extends Resource
{
    protected static ?string $model = RehabilitationCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static string | \UnitEnum | null $navigationGroup = 'Rehabilitasi Sosial';

    protected static ?string $navigationLabel = 'Kasus Rehabilitasi Sosial';

    protected static ?string $modelLabel = 'Kasus Rehabilitasi';

    protected static ?string $pluralModelLabel = 'Kasus Rehabilitasi';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'case_number';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kasus & Klien')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('client_id')
                                ->label('Pilih Klien (PPKS)')
                                ->relationship('client', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('handling_type')
                                ->label('Bentuk Penanganan')
                                ->options([
                                    HandlingType::DIRECT->value => HandlingType::DIRECT->label(),
                                    HandlingType::REFERRAL->value => HandlingType::REFERRAL->label(),
                                    HandlingType::BOTH->value => HandlingType::BOTH->label(),
                                ])
                                ->default(HandlingType::DIRECT->value)
                                ->required(),
                            Select::make('officer_id')
                                ->label('Petugas PJ Rehabilitasi')
                                ->options(User::role(['petugas_dinsos', 'administrator'])->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                    ]),

                Section::make('Sumber Kasus (Opsional)')
                    ->description('Tautkan jika kasus berasal dari tiket pengajuan atau pengaduan warga')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('service_request_id')
                                ->label('Nomor Tiket Layanan')
                                ->options(ServiceRequest::pluck('request_number', 'id'))
                                ->searchable()
                                ->nullable(),
                            Select::make('complaint_id')
                                ->label('Nomor Laporan Pengaduan')
                                ->options(Complaint::pluck('complaint_number', 'id'))
                                ->searchable()
                                ->nullable(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('case_number')
            ->defaultSort('received_at', 'desc')
            ->columns([
                TextColumn::make('case_number')
                    ->label('Nomor Kasus')
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable()
                    ->description(fn (RehabilitationCase $record) => $record->client?->category?->name ?? 'PPKS'),

                TextColumn::make('handling_type')
                    ->label('Penanganan')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Status Kasus')
                    ->badge()
                    ->color(fn (RehabilitationCase $record) => $record->status?->color() ?? 'gray')
                    ->formatStateUsing(fn ($state) => $state instanceof RehabilitationCaseStatus ? $state->label() : ($state ? RehabilitationCaseStatus::tryFrom($state)?->label() ?? $state : '-')),

                TextColumn::make('officer.name')
                    ->label('Petugas PJ')
                    ->placeholder('Belum Ditugaskan'),

                TextColumn::make('referrals_count')
                    ->counts('referrals')
                    ->label('Rujukan')
                    ->badge()
                    ->color('info'),

                TextColumn::make('monitoringRecords_count')
                    ->counts('monitoringRecords')
                    ->label('Monitoring')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('received_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Kasus')
                    ->options(collect(RehabilitationCaseStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
                SelectFilter::make('handling_type')
                    ->label('Bentuk Penanganan')
                    ->options([
                        HandlingType::DIRECT->value => HandlingType::DIRECT->label(),
                        HandlingType::REFERRAL->value => HandlingType::REFERRAL->label(),
                        HandlingType::BOTH->value => HandlingType::BOTH->label(),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // ACTION: CATAT ASSESSMENT
                Action::make('catat_assessment')
                    ->label('Assessment')
                    ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                    ->color('info')
                    ->form([
                        DatePicker::make('assessment_date')
                            ->label('Tanggal Pelaksanaan Assessment')
                            ->default(now())
                            ->required(),
                        Textarea::make('result')
                            ->label('Hasil Assessment Kondisi Klien')
                            ->required()
                            ->rows(3),
                        Textarea::make('service_needs')
                            ->label('Kebutuhan Pelayanan')
                            ->required()
                            ->rows(2),
                        Textarea::make('recommendation')
                            ->label('Rekomendasi Penanganan')
                            ->required()
                            ->rows(2),
                        Toggle::make('needs_referral')
                            ->label('Perlu Rujukan ke Lembaga Luar (Panti / RS / Balai)?')
                            ->default(false),
                    ])
                    ->action(function (RehabilitationCase $record, array $data) {
                        Assessment::create([
                            'rehabilitation_case_id' => $record->id,
                            'officer_id' => auth()->id() ?? 1,
                            'assessment_date' => $data['assessment_date'],
                            'result' => $data['result'],
                            'service_needs' => $data['service_needs'],
                            'recommendation' => $data['recommendation'],
                            'needs_referral' => $data['needs_referral'],
                        ]);

                        $record->update([
                            'status' => RehabilitationCaseStatus::SERVICE_PLANNING,
                        ]);

                        Notification::make()
                            ->title('Hasil Assessment Berhasil Dicatat')
                            ->success()
                            ->send();
                    }),

                // ACTION: BUAT RUJUKAN KE LEMBAGA (Hanya jika assessment perlu rujukan)
                Action::make('buat_rujukan')
                    ->label('Buat Rujukan')
                    ->icon(Heroicon::OutlinedArrowUpRight)
                    ->color('warning')
                    ->visible(fn (RehabilitationCase $record) => 
                        $record->assessments()->where('needs_referral', true)->exists()
                    )
                    ->form([
                        Select::make('referral_institution_id')
                            ->label('Lembaga Tujuan Rujukan')
                            ->options(ReferralInstitution::where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('assessment_id')
                            ->label('Dasar Assessment')
                            ->options(fn (RehabilitationCase $record) => 
                                $record->assessments()->pluck('recommendation', 'id')
                            )
                            ->required(),
                        DatePicker::make('referral_date')
                            ->label('Tanggal Surat Rujukan')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (RehabilitationCase $record, array $data) {
                        $referral = Referral::create([
                            'rehabilitation_case_id' => $record->id,
                            'assessment_id' => $data['assessment_id'],
                            'referral_institution_id' => $data['referral_institution_id'],
                            'officer_id' => auth()->id() ?? 1,
                            'referral_date' => $data['referral_date'],
                            'status' => ReferralStatus::SENT,
                        ]);

                        $record->update([
                            'status' => RehabilitationCaseStatus::IN_SERVICE,
                        ]);

                        Notification::make()
                            ->title("Rujukan Berhasil Dibuat: {$referral->referral_number}")
                            ->success()
                            ->send();
                    }),

                // ACTION: CATAT MONITORING
                Action::make('catat_monitoring')
                    ->label('Catat Monitoring')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('primary')
                    ->visible(fn (RehabilitationCase $record) => 
                        in_array($record->status, [
                            RehabilitationCaseStatus::IN_SERVICE,
                            RehabilitationCaseStatus::MONITORING,
                        ])
                    )
                    ->form([
                        Select::make('referral_id')
                            ->label('Rujukan yang Dimonitor (Opsional)')
                            ->options(fn (RehabilitationCase $record) => 
                                $record->referrals()->pluck('referral_number', 'id')
                            )
                            ->nullable(),
                        DatePicker::make('monitoring_date')
                            ->label('Tanggal Monitoring')
                            ->default(now())
                            ->required(),
                        Textarea::make('progress')
                            ->label('Perkembangan Kondisi Klien')
                            ->required()
                            ->rows(2),
                        Textarea::make('result_notes')
                            ->label('Catatan Hasil Monitoring')
                            ->required()
                            ->rows(2),
                    ])
                    ->action(function (RehabilitationCase $record, array $data) {
                        MonitoringRecord::create([
                            'rehabilitation_case_id' => $record->id,
                            'referral_id' => $data['referral_id'] ?? null,
                            'officer_id' => auth()->id() ?? 1,
                            'monitoring_date' => $data['monitoring_date'],
                            'progress' => $data['progress'],
                            'result_notes' => $data['result_notes'],
                        ]);

                        $record->update([
                            'status' => RehabilitationCaseStatus::MONITORING,
                        ]);

                        Notification::make()
                            ->title('Catatan Monitoring Berhasil Disimpan')
                            ->success()
                            ->send();
                    }),

                // ACTION: TUTUP KASUS (SELESAI)
                Action::make('tutup_kasus')
                    ->label('Tutup Kasus')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (RehabilitationCase $record) => 
                        $record->status !== RehabilitationCaseStatus::CLOSED &&
                        $record->monitoringRecords()->exists()
                    )
                    ->form([
                        Textarea::make('handling_result')
                            ->label('Hasil Akhir Pelayanan / Penanganan')
                            ->helperText('Wajib diisi sebelum kasus dinyatakan selesai/ditutup')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (RehabilitationCase $record, array $data) {
                        $record->update([
                            'status' => RehabilitationCaseStatus::CLOSED,
                            'handling_result' => $data['handling_result'],
                            'closed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Kasus Rehabilitasi Sosial Resmi Selesai & Ditutup')
                            ->success()
                            ->send();
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
            'index' => ListRehabilitationCases::route('/'),
            'create' => CreateRehabilitationCase::route('/create'),
            'view' => ViewRehabilitationCase::route('/{record}'),
            'edit' => EditRehabilitationCase::route('/{record}/edit'),
        ];
    }
}
