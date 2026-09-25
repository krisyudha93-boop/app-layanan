<?php

namespace App\Filament\Resources\WorkUnits;

use App\Filament\Resources\WorkUnits\Pages\CreateWorkUnit;
use App\Filament\Resources\WorkUnits\Pages\EditWorkUnit;
use App\Filament\Resources\WorkUnits\Pages\ListWorkUnits;
use App\Models\WorkUnit;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class WorkUnitResource extends Resource
{
    protected static ?string $model = WorkUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Unit Kerja / Bidang';

    protected static ?string $modelLabel = 'Unit Kerja';

    protected static ?string $pluralModelLabel = 'Unit Kerja';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Unit Kerja')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Unit Kerja / Bidang')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Unit Kerja')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Jumlah Pegawai'),
            ])
            ->filters([
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
            'index' => ListWorkUnits::route('/'),
            'create' => CreateWorkUnit::route('/create'),
            'edit' => EditWorkUnit::route('/{record}/edit'),
        ];
    }
}
