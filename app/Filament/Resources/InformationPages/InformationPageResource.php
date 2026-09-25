<?php

namespace App\Filament\Resources\InformationPages;

use App\Filament\Resources\InformationPages\Pages\CreateInformationPage;
use App\Filament\Resources\InformationPages\Pages\EditInformationPage;
use App\Filament\Resources\InformationPages\Pages\ListInformationPages;
use App\Models\InformationPage;
use App\Models\ServiceType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InformationPageResource extends Resource
{
    protected static ?string $model = InformationPage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static string | \UnitEnum | null $navigationGroup = 'Informasi Publik';

    protected static ?string $navigationLabel = 'Informasi Layanan & FAQ';

    protected static ?string $modelLabel = 'Informasi Layanan';

    protected static ?string $pluralModelLabel = 'Informasi Layanan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten & Informasi Utama')
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('title')
                                ->label('Judul Informasi / Layanan')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn (callable $set, $state) => $set('slug', Str::slug($state)))
                                ->maxLength(255),
                            TextInput::make('slug')
                                ->label('URL Slug')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'program' => 'Program Sosial',
                                    'rehabilitation' => 'Rehabilitasi Sosial',
                                    'disability' => 'Penyandang Disabilitas',
                                    'elderly' => 'Lanjut Usia (Lansia)',
                                    'complaint' => 'Layanan Pengaduan',
                                    'other' => 'Lainnya',
                                ])
                                ->required(),
                            Select::make('service_type_id')
                                ->label('Tautkan ke Master Layanan (Opsional)')
                                ->options(ServiceType::pluck('name', 'id'))
                                ->searchable()
                                ->nullable(),
                            Select::make('publish_status')
                                ->label('Status Publikasi')
                                ->options([
                                    'draft' => 'Draf (Belum Tayang)',
                                    'published' => 'Dipublikasikan',
                                    'archived' => 'Diarsipkan',
                                ])
                                ->default('published')
                                ->required(),
                            TextInput::make('service_hours')
                                ->label('Jam Pelayanan')
                                ->default('Senin - Jumat: 08.00 - 15.00 WIB')
                                ->maxLength(100),
                        ]),
                        Textarea::make('description')
                            ->label('Deskripsi Lengkap Layanan')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('requirements')
                            ->label('Persyaratan Layanan')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('procedure')
                            ->label('Alur / Prosedur Pelayanan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Formulir Unduhan Resmi')
                    ->schema([
                        Repeater::make('downloadableForms')
                            ->relationship('downloadableForms')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Formulir')
                                    ->required(),
                                FileUpload::make('file_path')
                                    ->label('Berkas Formulir (PDF/Doc)')
                                    ->disk('local')
                                    ->directory('forms')
                                    ->required(),
                                TextInput::make('version')
                                    ->label('Versi Formulir')
                                    ->default('v1.0')
                                    ->required(),
                                Toggle::make('is_current')
                                    ->label('Versi Berlaku Saat Ini')
                                    ->default(true),
                            ])
                            ->columns(4)
                            ->defaultItems(0),
                    ]),

                Section::make('Tanya Jawab (FAQ)')
                    ->schema([
                        Repeater::make('faqs')
                            ->relationship('faqs')
                            ->schema([
                                TextInput::make('question')
                                    ->label('Pertanyaan')
                                    ->required(),
                                Textarea::make('answer')
                                    ->label('Jawaban')
                                    ->required()
                                    ->rows(2),
                                Toggle::make('is_active')
                                    ->label('Tampilkan di Publik')
                                    ->default(true),
                            ])
                            ->columns(1)
                            ->defaultItems(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('publish_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'archived' => 'warning',
                        default => 'secondary',
                    }),
                TextColumn::make('service_hours')
                    ->label('Waktu Layanan')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'program' => 'Program Sosial',
                        'rehabilitation' => 'Rehabilitasi Sosial',
                        'disability' => 'Penyandang Disabilitas',
                        'elderly' => 'Lanjut Usia (Lansia)',
                        'complaint' => 'Layanan Pengaduan',
                        'other' => 'Lainnya',
                    ])
                    ->label('Kategori'),
                SelectFilter::make('publish_status')
                    ->options([
                        'published' => 'Dipublikasikan',
                        'draft' => 'Draf',
                        'archived' => 'Diarsipkan',
                    ])
                    ->label('Status Publikasi'),
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
            'index' => ListInformationPages::route('/'),
            'create' => CreateInformationPage::route('/create'),
            'edit' => EditInformationPage::route('/{record}/edit'),
        ];
    }
}
