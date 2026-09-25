<?php

namespace App\Filament\Resources\ReferralInstitutions;

use App\Filament\Resources\ReferralInstitutions\Pages\CreateReferralInstitution;
use App\Filament\Resources\ReferralInstitutions\Pages\EditReferralInstitution;
use App\Filament\Resources\ReferralInstitutions\Pages\ListReferralInstitutions;
use App\Models\ReferralInstitution;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class ReferralInstitutionResource extends Resource
{
    protected static ?string $model = ReferralInstitution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Layanan';

    protected static ?string $navigationLabel = 'Lembaga Rujukan';

    protected static ?string $modelLabel = 'Lembaga Rujukan';

    protected static ?string $pluralModelLabel = 'Lembaga Rujukan';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Lembaga Rujukan')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lembaga / Panti / RS')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Balai Besar Rehabilitasi Sosial, RSJ Menur, Panti Lansia'),
                            Select::make('type')
                                ->label('Jenis Lembaga')
                                ->options([
                                    'panti' => 'Panti Sosial',
                                    'balai' => 'Balai / Sentra Kemensos',
                                    'RS' => 'Rumah Sakit / RSJ',
                                    'LKS' => 'Lembaga Kesejahteraan Sosial (LKS)',
                                ])
                                ->required(),
                            TextInput::make('contact')
                                ->label('Kontak / Narahubung')
                                ->placeholder('Telp / WhatsApp / Nama Kontak')
                                ->maxLength(255),
                            Toggle::make('is_active')
                                ->label('Status Aktif (Dapat Dirujuk)')
                                ->default(true),
                        ]),
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
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
                    ->label('Nama Lembaga')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('contact')
                    ->label('Kontak')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('referrals_count')
                    ->counts('referrals')
                    ->label('Total Rujukan')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'panti' => 'Panti Sosial',
                        'balai' => 'Balai / Sentra Kemensos',
                        'RS' => 'Rumah Sakit / RSJ',
                        'LKS' => 'Lembaga Kesejahteraan Sosial (LKS)',
                    ])
                    ->label('Jenis Lembaga'),
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
            'index' => ListReferralInstitutions::route('/'),
            'create' => CreateReferralInstitution::route('/create'),
            'edit' => EditReferralInstitution::route('/{record}/edit'),
        ];
    }
}
