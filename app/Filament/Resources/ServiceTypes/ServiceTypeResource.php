<?php

namespace App\Filament\Resources\ServiceTypes;

use App\Enums\ServiceHandler;
use App\Filament\Resources\ServiceTypes\Pages\CreateServiceType;
use App\Filament\Resources\ServiceTypes\Pages\EditServiceType;
use App\Filament\Resources\ServiceTypes\Pages\ListServiceTypes;
use App\Models\ServiceType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

class ServiceTypeResource extends Resource
{
    protected static ?string $model = ServiceType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Jenis Layanan & Syarat';

    protected static ?string $modelLabel = 'Jenis Layanan';

    protected static ?string $pluralModelLabel = 'Jenis Layanan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('code')
                                ->label('Kode Layanan (Prefix Tiket)')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(20)
                                ->placeholder('Contoh: DTSEN, PBI, REHSOS'),
                            TextInput::make('name')
                                ->label('Nama Layanan')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('category')
                                ->label('Kategori')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Contoh: Perlindungan Sosial, Jaminan Kesehatan'),
                            Select::make('handler')
                                ->label('Handler Khusus (Fitur Sistem)')
                                ->options([
                                    ServiceHandler::GENERIC->value => ServiceHandler::GENERIC->label(),
                                    ServiceHandler::DTSEN->value => ServiceHandler::DTSEN->label(),
                                    ServiceHandler::PBI->value => ServiceHandler::PBI->label(),
                                ])
                                ->required(),
                            TextInput::make('sla_days')
                                ->label('Target SLA (Hari Kerja)')
                                ->numeric()
                                ->default(3)
                                ->nullable(),
                            Grid::make(2)->schema([
                                Toggle::make('needs_assessment')
                                    ->label('Memerlukan Assessment')
                                    ->default(false),
                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi Layanan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Dokumen Persyaratan')
                    ->description('Daftar berkas yang wajib / opsional diunggah oleh pemohon')
                    ->schema([
                        Repeater::make('requirements')
                            ->relationship('requirements')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Dokumen')
                                    ->required()
                                    ->placeholder('Misal: KTP Pemohon, Kartu Keluarga, Surat Ket. Faskes'),
                                Toggle::make('is_mandatory')
                                    ->label('Wajib')
                                    ->default(true),
                                TextInput::make('allowed_mimes')
                                    ->label('Format Diizinkan')
                                    ->default('pdf,jpg,jpeg,png')
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(1),
                            ])
                            ->columns(4)
                            ->defaultItems(2)
                            ->orderColumn('sort_order'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                TextColumn::make('handler')
                    ->label('Handler')
                    ->badge(),
                TextColumn::make('sla_days')
                    ->label('SLA')
                    ->suffix(' hari')
                    ->sortable(),
                IconColumn::make('needs_assessment')
                    ->label('Assessment')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('handler')
                    ->options([
                        ServiceHandler::GENERIC->value => ServiceHandler::GENERIC->label(),
                        ServiceHandler::DTSEN->value => ServiceHandler::DTSEN->label(),
                        ServiceHandler::PBI->value => ServiceHandler::PBI->label(),
                    ])
                    ->label('Handler Khusus'),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListServiceTypes::route('/'),
            'create' => CreateServiceType::route('/create'),
            'edit' => EditServiceType::route('/{record}/edit'),
        ];
    }
}
