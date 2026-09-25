<?php

namespace App\Filament\Resources\Complaints;

use App\Enums\ComplaintStatus;
use App\Enums\HandlingType;
use App\Filament\Resources\Complaints\Pages\CreateComplaint;
use App\Filament\Resources\Complaints\Pages\EditComplaint;
use App\Filament\Resources\Complaints\Pages\ListComplaints;
use App\Filament\Resources\Complaints\Pages\ViewComplaint;
use App\Models\Client;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Disposition;
use App\Models\District;
use App\Models\RehabilitationCase;
use App\Models\User;
use App\Models\Village;
use App\Models\WorkUnit;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string | \UnitEnum | null $navigationGroup = 'Pengaduan Masyarakat';

    protected static ?string $navigationLabel = 'Laporan & Pengaduan';

    protected static ?string $modelLabel = 'Pengaduan Sosial';

    protected static ?string $pluralModelLabel = 'Pengaduan Sosial';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'complaint_number';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pelapor')
                    ->description('Data warga yang melaporkan permasalahan sosial')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('reporter_name')
                                ->label('Nama Pelapor')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('reporter_phone')
                                ->label('Nomor WhatsApp / HP Pelapor')
                                ->tel()
                                ->required()
                                ->maxLength(20),
                        ]),
                    ]),

                Section::make('Lokasi & Uraian Kejadian')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('complaint_category_id')
                                ->label('Kategori Masalah Sosial')
                                ->options(ComplaintCategory::where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('district_id')
                                ->label('Kecamatan Tempat Kejadian')
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
                        TextInput::make('location_detail')
                            ->label('Patokan Lokasi Kejadian')
                            ->placeholder('Contoh: Dekat jembatan pasar, depan pos kamling RT 02')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Uraian Permasalahan')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Foto & Bukti Pendukung')
                    ->schema([
                        Repeater::make('attachments')
                            ->relationship('attachments')
                            ->schema([
                                FileUpload::make('file_path')
                                    ->label('Unggah Foto / Dokumen Bukti')
                                    ->disk('local')
                                    ->directory('complaint_attachments')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'application/pdf'])
                                    ->maxSize(10240)
                                    ->required(),
                                Select::make('type')
                                    ->label('Jenis Bukti')
                                    ->options([
                                        'photo' => 'Foto Dokumentasi',
                                        'document' => 'Dokumen / Surat',
                                    ])
                                    ->default('photo')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('complaint_number')
            ->defaultSort('reported_at', 'desc')
            ->columns([
                TextColumn::make('complaint_number')
                    ->label('Nomor Laporan')
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('reporter_name')
                    ->label('Pelapor')
                    ->searchable()
                    ->description(fn (Complaint $record) => $record->reporter_phone),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('warning')
                    ->searchable(),

                TextColumn::make('village.name')
                    ->label('Lokasi')
                    ->description(fn (Complaint $record) => 'Kec. ' . $record->village?->district?->name),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (Complaint $record) => $record->status?->color() ?? 'gray')
                    ->formatStateUsing(fn ($state) => $state instanceof ComplaintStatus ? $state->label() : ($state ? ComplaintStatus::tryFrom($state)?->label() ?? $state : '-')),

                TextColumn::make('officer.name')
                    ->label('Petugas PJ')
                    ->placeholder('Belum Ditugaskan'),

                TextColumn::make('reported_at')
                    ->label('Waktu Lapor')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Laporan')
                    ->options(collect(ComplaintStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
                SelectFilter::make('complaint_category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                // ACTION: VERIFIKASI & KLARIFIKASI
                Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->icon(Heroicon::OutlinedCheck)
                    ->color('info')
                    ->visible(fn (Complaint $record) => 
                        in_array($record->status, [ComplaintStatus::RECEIVED, ComplaintStatus::CLARIFICATION_REQUESTED])
                    )
                    ->form([
                        Select::make('decision')
                            ->label('Hasil Verifikasi Awal')
                            ->options([
                                'valid' => 'Laporan Valid (Siap Didisposisikan)',
                                'clarify' => 'Minta Klarifikasi / Data Kurang Jelas',
                                'invalid' => 'Laporan Tidak Valid / Hoaks',
                            ])
                            ->required(),
                        Textarea::make('verification_result')
                            ->label('Catatan Hasil Verifikasi')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $targetStatus = match ($data['decision']) {
                            'valid' => ComplaintStatus::VERIFICATION,
                            'clarify' => ComplaintStatus::CLARIFICATION_REQUESTED,
                            'invalid' => ComplaintStatus::INVALID,
                        };

                        $record->update([
                            'status' => $targetStatus,
                            'verification_result' => $data['verification_result'],
                            'officer_id' => auth()->id() ?? $record->officer_id,
                        ]);

                        Notification::make()->title('Hasil Verifikasi Dicatat')->send();
                    }),

                // ACTION: DISPOSISI PETUGAS
                Action::make('disposisi')
                    ->label('Disposisi')
                    ->icon(Heroicon::OutlinedArrowsRightLeft)
                    ->color('primary')
                    ->visible(fn (Complaint $record) => 
                        in_array($record->status, [ComplaintStatus::RECEIVED, ComplaintStatus::VERIFICATION])
                    )
                    ->form([
                        Select::make('work_unit_id')
                            ->label('Unit Kerja Penanggung Jawab')
                            ->options(WorkUnit::where('is_active', true)->pluck('name', 'id'))
                            ->required(),
                        Select::make('officer_id')
                            ->label('Petugas yang Ditugaskan')
                            ->options(User::role(['petugas_dinsos', 'administrator'])->pluck('name', 'id'))
                            ->required(),
                        Textarea::make('instructions')
                            ->label('Instruksi Penanganan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $record->update([
                            'officer_id' => $data['officer_id'],
                            'status' => ComplaintStatus::DISPATCHED,
                        ]);

                        Disposition::create([
                            'dispositionable_type' => Complaint::class,
                            'dispositionable_id' => $record->id,
                            'from_user_id' => auth()->id() ?? 1,
                            'to_work_unit_id' => $data['work_unit_id'],
                            'to_user_id' => $data['officer_id'],
                            'instructions' => $data['instructions'],
                            'disposed_at' => now(),
                        ]);

                        Notification::make()->title('Laporan Berhasil Didisposisikan')->success()->send();
                    }),

                // ACTION: TINDAK LANJUT / PENANGANAN
                Action::make('tindak_lanjut')
                    ->label('Tindak Lanjut')
                    ->icon(Heroicon::OutlinedWrenchScrewdriver)
                    ->color('warning')
                    ->visible(fn (Complaint $record) => 
                        in_array($record->status, [ComplaintStatus::DISPATCHED, ComplaintStatus::IN_HANDLING])
                    )
                    ->form([
                        Textarea::make('action_taken')
                            ->label('Tindakan yang Telah Dilakukan')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $record->update([
                            'status' => ComplaintStatus::IN_HANDLING,
                            'action_taken' => $data['action_taken'],
                        ]);

                        Notification::make()->title('Progres Tindakan Dicatat')->success()->send();
                    }),

                // ACTION: SELESAIKAN PENGADUAN
                Action::make('selesaikan')
                    ->label('Selesaikan')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Complaint $record) => 
                        $record->status === ComplaintStatus::IN_HANDLING
                    )
                    ->form([
                        Textarea::make('action_taken')
                            ->label('Laporan Hasil Akhir Penanganan Masalah')
                            ->required()
                            ->default(fn (Complaint $record) => $record->action_taken)
                            ->rows(3),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $record->update([
                            'status' => ComplaintStatus::RESOLVED,
                            'action_taken' => $data['action_taken'],
                            'resolved_at' => now(),
                        ]);

                        Notification::make()->title('Pengaduan Resmi Diselesaikan')->success()->send();
                    }),

                // ACTION: KONVERSI KE KASUS REHABILITASI SOSIAL
                Action::make('konversi_rehsos')
                    ->label('Buat Kasus Rehsos')
                    ->icon(Heroicon::OutlinedHeart)
                    ->color('danger')
                    ->visible(fn (Complaint $record) => 
                        !RehabilitationCase::where('complaint_id', $record->id)->exists()
                    )
                    ->form([
                        Select::make('client_id')
                            ->label('Pilih Klien Terdaftar / Buat Baru di Menu Klien')
                            ->options(Client::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('handling_type')
                            ->label('Bentuk Penanganan yang Dibutuhkan')
                            ->options([
                                HandlingType::DIRECT->value => HandlingType::DIRECT->label(),
                                HandlingType::REFERRAL->value => HandlingType::REFERRAL->label(),
                                HandlingType::BOTH->value => HandlingType::BOTH->label(),
                            ])
                            ->default(HandlingType::DIRECT->value)
                            ->required(),
                    ])
                    ->action(function (Complaint $record, array $data) {
                        $case = RehabilitationCase::create([
                            'client_id' => $data['client_id'],
                            'complaint_id' => $record->id,
                            'officer_id' => auth()->id() ?? $record->officer_id ?? 1,
                            'handling_type' => $data['handling_type'],
                        ]);

                        $record->update([
                            'status' => ComplaintStatus::IN_HANDLING,
                            'action_taken' => 'Diteruskan menjadi kasus penanganan rehabilitasi sosial No: ' . $case->case_number,
                        ]);

                        Notification::make()
                            ->title("Kasus Rehabilitasi Sosial Berhasil Dibuat: {$case->case_number}")
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
            'index' => ListComplaints::route('/'),
            'create' => CreateComplaint::route('/create'),
            'view' => ViewComplaint::route('/{record}'),
            'edit' => EditComplaint::route('/{record}/edit'),
        ];
    }
}
