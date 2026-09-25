<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\District;
use App\Models\User;
use App\Models\Village;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
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
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string | \UnitEnum | null $navigationGroup = 'Pengaturan Pengguna';

    protected static ?string $navigationLabel = 'Pengguna & Hak Akses';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun & Kontak')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('name')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            TextInput::make('password')
                                ->label('Kata Sandi')
                                ->password()
                                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                ->dehydrated(fn ($state) => filled($state))
                                ->required(fn (string $context): bool => $context === 'create')
                                ->maxLength(255),
                            TextInput::make('phone')
                                ->label('Nomor Telepon / WA')
                                ->tel()
                                ->maxLength(20),
                            TextInput::make('nik')
                                ->label('NIK')
                                ->length(16)
                                ->nullable(),
                            Toggle::make('is_active')
                                ->label('Status Aktif')
                                ->default(true),
                        ]),
                    ]),

                Section::make('Penugasan & Peran (Role)')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('roles')
                                ->label('Peran (Role)')
                                ->relationship('roles', 'name')
                                ->multiple()
                                ->preload()
                                ->required(),
                            Select::make('work_unit_id')
                                ->label('Unit Kerja / Bidang')
                                ->relationship('workUnit', 'name')
                                ->searchable()
                                ->preload()
                                ->nullable(),
                            Select::make('district_id')
                                ->label('Wilayah Kecamatan (Operator)')
                                ->relationship('district', 'name')
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set) => $set('village_id', null))
                                ->nullable(),
                            Select::make('village_id')
                                ->label('Wilayah Desa/Kelurahan (Operator)')
                                ->relationship('village', 'name', fn ($query, callable $get) => 
                                    $get('district_id') ? $query->where('district_id', $get('district_id')) : $query
                                )
                                ->searchable()
                                ->preload()
                                ->nullable(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Peran')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('workUnit.name')
                    ->label('Unit Kerja')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('district.name')
                    ->label('Kecamatan')
                    ->placeholder('-')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Peran'),
                SelectFilter::make('work_unit_id')
                    ->relationship('workUnit', 'name')
                    ->label('Unit Kerja'),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
