<?php

namespace App\Filament\Resources\ClientCategories;

use App\Filament\Resources\ClientCategories\Pages\CreateClientCategory;
use App\Filament\Resources\ClientCategories\Pages\EditClientCategory;
use App\Filament\Resources\ClientCategories\Pages\ListClientCategories;
use App\Models\ClientCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientCategoryResource extends Resource
{
    protected static ?string $model = ClientCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Kategori Klien Rehsos';

    protected static ?string $modelLabel = 'Kategori Klien';

    protected static ?string $pluralModelLabel = 'Kategori Klien';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori Klien')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Lansia Terlantar, Disabilitas Fisik, ODGJ Terlantar, Anak Terlantar'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Kategori Klien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('clients_count')
                    ->counts('clients')
                    ->label('Jumlah Terdaftar')
                    ->badge(),
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
            'index' => ListClientCategories::route('/'),
            'create' => CreateClientCategory::route('/create'),
            'edit' => EditClientCategory::route('/{record}/edit'),
        ];
    }
}
