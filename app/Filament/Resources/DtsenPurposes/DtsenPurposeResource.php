<?php

namespace App\Filament\Resources\DtsenPurposes;

use App\Filament\Resources\DtsenPurposes\Pages\CreateDtsenPurpose;
use App\Filament\Resources\DtsenPurposes\Pages\EditDtsenPurpose;
use App\Filament\Resources\DtsenPurposes\Pages\ListDtsenPurposes;
use App\Models\DtsenPurpose;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class DtsenPurposeResource extends Resource
{
    protected static ?string $model = DtsenPurpose::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Tujuan SK DTSEN & Desil';

    protected static ?string $modelLabel = 'Tujuan SK DTSEN';

    protected static ?string $pluralModelLabel = 'Tujuan SK DTSEN';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Aturan & Kriteria Tujuan SK DTSEN')
                    ->description('Tentukan batas maksimal desil dan masa berlaku surat sesuai regulasi')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('code')
                                ->label('Kode Unik')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->placeholder('Contoh: spmb, pip, kip_kuliah, bansos'),
                            TextInput::make('name')
                                ->label('Nama Tujuan Penggunaan')
                                ->required()
                                ->placeholder('Contoh: SPMB Jalur Afirmasi, Bantuan PIP'),
                            TextInput::make('max_decile')
                                ->label('Batas Desil Maksimal')
                                ->helperText('Surat hanya diterbitkan jika desil hasil verifikasi SIKS-NG <= angka ini (1 s/d 10)')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(10)
                                ->default(5)
                                ->required(),
                            TextInput::make('validity_days')
                                ->label('Masa Berlaku (Hari)')
                                ->helperText('Kosongkan bila berlaku selamanya / tanpa masa kedaluwarsa')
                                ->numeric()
                                ->suffix('hari')
                                ->nullable(),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true),
                        ]),
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
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Tujuan Penggunaan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('max_decile')
                    ->label('Desil Maksimal')
                    ->badge()
                    ->color('warning')
                    ->prefix('Desil ≤ ')
                    ->sortable(),
                TextColumn::make('validity_days')
                    ->label('Masa Berlaku')
                    ->suffix(' hari')
                    ->placeholder('Tanpa Batas'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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
            'index' => ListDtsenPurposes::route('/'),
            'create' => CreateDtsenPurpose::route('/create'),
            'edit' => EditDtsenPurpose::route('/{record}/edit'),
        ];
    }
}
