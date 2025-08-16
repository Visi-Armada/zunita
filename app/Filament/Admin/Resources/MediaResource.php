<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'original_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(auth()->id()),
                
                Grid::make(2)
                    ->schema([
                        Section::make('File Information')
                            ->schema([
                                FileUpload::make('file')
                                    ->label('Upload File')
                                    ->disk('public')
                                    ->directory('media')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                    ->maxSize(10240) // 10MB
                                    ->helperText('Supported formats: Images, PDF, Word documents. Max size: 10MB'),

                                TextInput::make('original_name')
                                    ->label('Original Filename')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('filename')
                                    ->label('System Filename')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Auto-generated system filename'),

                                Select::make('mime_type')
                                    ->label('File Type')
                                    ->options([
                                        'image/jpeg' => 'JPEG Image',
                                        'image/png' => 'PNG Image',
                                        'image/gif' => 'GIF Image',
                                        'image/webp' => 'WebP Image',
                                        'application/pdf' => 'PDF Document',
                                        'application/msword' => 'Word Document (.doc)',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word Document (.docx)',
                                        'application/vnd.ms-excel' => 'Excel Document (.xls)',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel Document (.xlsx)',
                                    ])
                                    ->required()
                                    ->searchable(),

                                TextInput::make('size')
                                    ->label('File Size (bytes)')
                                    ->numeric()
                                    ->required()
                                    ->helperText('File size in bytes'),

                                TextInput::make('path')
                                    ->label('File Path')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Path to the file in storage'),

                                Select::make('disk')
                                    ->label('Storage Disk')
                                    ->options([
                                        'public' => 'Public Disk',
                                        'local' => 'Local Disk',
                                        's3' => 'Amazon S3',
                                    ])
                                    ->default('public')
                                    ->required(),
                            ]),

                        Section::make('Metadata')
                            ->schema([
                                TextInput::make('alt_text')
                                    ->label('Alt Text')
                                    ->maxLength(255)
                                    ->helperText('Alternative text for images (accessibility)'),

                                Textarea::make('caption')
                                    ->label('Caption')
                                    ->rows(3)
                                    ->maxLength(1000)
                                    ->helperText('Caption or description for the file'),

                                Toggle::make('is_featured')
                                    ->label('Featured Media')
                                    ->helperText('Featured media may appear in special sections'),

                                TextInput::make('order')
                                    ->label('Display Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),

                                Select::make('mediable_type')
                                    ->label('Related Model Type')
                                    ->options([
                                        'App\Models\Page' => 'Page',
                                        'App\Models\Initiative' => 'Initiative',
                                        'App\Models\InitiativeApplication' => 'Initiative Application',
                                    ])
                                    ->searchable()
                                    ->helperText('Type of model this media belongs to'),

                                TextInput::make('mediable_id')
                                    ->label('Related Model ID')
                                    ->numeric()
                                    ->helperText('ID of the related model'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Preview')
                    ->circular()
                    ->size(50)
                    ->visibility('public')
                    ->disk('public'),

                TextColumn::make('original_name')
                    ->label('Filename')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('mime_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (Media $record): string => 
                        $record->isImage() ? 'success' : 'primary'
                    )
                    ->formatStateUsing(fn (string $state): string => 
                        match($state) {
                            'image/jpeg', 'image/png', 'image/gif', 'image/webp' => 'Image',
                            'application/pdf' => 'PDF',
                            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word',
                            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel',
                            default => 'Document',
                        }
                    ),

                TextColumn::make('file_size_formatted')
                    ->label('Size')
                    ->sortable(query: fn (Builder $query, string $direction): Builder => 
                        $query->orderBy('size', $direction)
                    ),

                TextColumn::make('mediable_type')
                    ->label('Related To')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => 
                        match($state) {
                            'App\Models\Page' => 'Page',
                            'App\Models\Initiative' => 'Initiative',
                            'App\Models\InitiativeApplication' => 'Application',
                            default => 'Unknown',
                        }
                    ),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('mime_type')
                    ->label('File Type')
                    ->options([
                        'image/jpeg' => 'JPEG Images',
                        'image/png' => 'PNG Images',
                        'image/gif' => 'GIF Images',
                        'image/webp' => 'WebP Images',
                        'application/pdf' => 'PDF Documents',
                        'application/msword' => 'Word Documents',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word Documents (.docx)',
                        'application/vnd.ms-excel' => 'Excel Documents',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel Documents (.xlsx)',
                    ]),

                SelectFilter::make('mediable_type')
                    ->label('Related To')
                    ->options([
                        'App\Models\Page' => 'Pages',
                        'App\Models\Initiative' => 'Initiatives',
                        'App\Models\InitiativeApplication' => 'Applications',
                    ]),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Media $record): string => $record->url)
                    ->openUrlInNewTab()
                    ->visible(fn (Media $record): bool => $record->isImage()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('feature')
                        ->label('Mark as Featured')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_featured' => true]);
                            });
                        })
                        ->requiresConfirmation(),

                    BulkAction::make('unfeature')
                        ->label('Remove Featured Status')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_featured' => false]);
                            });
                        })
                        ->requiresConfirmation(),

                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
