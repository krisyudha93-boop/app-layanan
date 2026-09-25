<?php

namespace App\Filament\Resources\Clients;

use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\District;
use App\Models\Village;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string | \UnitEnum | null $navigationGroup = 'Rehabilitasi Sosial';

    protected static ?string $navigationLabel = 'Data Klien (PPKS)';

    protected static ?string $modelLabel = 'Klien Rehabilitasi';

    protected static ?string $pluralModelLabel = 'Klien Rehabilitasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Klien')
                    ->description('Data diri Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap Klien')
                                ->required()
                                ->maxLength(255),
                            Select::make('client_category_id')
                                ->label('Kategori PPKS')
                                ->options(ClientCategory::pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required(),
                            TextInput::make('nik')
                                ->label('NIK (Bila Ada)')
                                ->length(16)
                                ->numeric()
                                ->nullable(),
                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ])
                                ->required(),
                            DatePicker::make('birth_date')
                                ->label('Tanggal Lahir')
                                ->nullable(),
                            TextInput::make('phone')
                                ->label('Kontak / No. HP Klien / Keluarga')
                                ->tel()
                                ->nullable(),
                        ]),
                    ]),

                Section::make('Domisili / Lokasi Ditemukan')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('district_id')
                                ->label('Kecamatan')
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
                            ->label('Alamat Lengkap / Lokasi Keberadaan')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Client $record) => $record->nik ? 'NIK: ' . $record->nik : 'Tanpa Identitas'),
                TextColumn::make('category.name')
                    ->label('Kategori PPKS')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('gender')
                    ->label('JK')
                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                TextColumn::make('village.name')
                    ->label('Wilayah')
                    ->description(fn (Client $record) => 'Kec. ' . $record->village?->district?->name),
                TextColumn::make('rehabilitation_cases_count')
                    ->counts('rehabilitationCases')
                    ->label('Kasus Rehsos')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                SelectFilter::make('client_category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori PPKS'),
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
            'index' => ListClients::route('/'),
            'create' => CreateClient::route('/create'),
            'edit' => EditClient::route('/{record}/edit'),
        ];
    }
}
