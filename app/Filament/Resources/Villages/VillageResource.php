<?php

namespace App\Filament\Resources\Villages;

use App\Filament\Resources\Villages\Pages\CreateVillage;
use App\Filament\Resources\Villages\Pages\EditVillage;
use App\Filament\Resources\Villages\Pages\ListVillages;
use App\Models\Village;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VillageResource extends Resource
{
    protected static ?string $model = Village::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Wilayah';

    protected static ?string $navigationLabel = 'Desa / Kelurahan';

    protected static ?string $modelLabel = 'Desa/Kelurahan';

    protected static ?string $pluralModelLabel = 'Desa/Kelurahan';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Desa / Kelurahan')
                    ->schema([
                        Select::make('district_id')
                            ->label('Kecamatan')
                            ->relationship('district', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode Desa (Kemendagri)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                        TextInput::make('name')
                            ->label('Nama Desa / Kelurahan')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('district.name')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Desa/Kelurahan')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('district_id')
                    ->relationship('district', 'name')
                    ->label('Kecamatan')
                    ->searchable()
                    ->preload(),
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
            'index' => ListVillages::route('/'),
            'create' => CreateVillage::route('/create'),
            'edit' => EditVillage::route('/{record}/edit'),
        ];
    }
}
