<?php

namespace App\Filament\Resources\ComplaintCategories;

use App\Filament\Resources\ComplaintCategories\Pages\CreateComplaintCategory;
use App\Filament\Resources\ComplaintCategories\Pages\EditComplaintCategory;
use App\Filament\Resources\ComplaintCategories\Pages\ListComplaintCategories;
use App\Models\ComplaintCategory;
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

class ComplaintCategoryResource extends Resource
{
    protected static ?string $model = ComplaintCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Kategori Pengaduan';

    protected static ?string $modelLabel = 'Kategori Pengaduan';

    protected static ?string $pluralModelLabel = 'Kategori Pengaduan';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategori Pengaduan & Laporan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori Pengaduan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Bansos Tidak Tepat Sasaran, Penemuan ODGJ Terlantar'),
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
                    ->label('Kategori Pengaduan')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('complaints_count')
                    ->counts('complaints')
                    ->label('Jumlah Laporan')
                    ->badge(),
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
            'index' => ListComplaintCategories::route('/'),
            'create' => CreateComplaintCategory::route('/create'),
            'edit' => EditComplaintCategory::route('/{record}/edit'),
        ];
    }
}
