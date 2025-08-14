<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InitiativeResource\Pages;
use App\Models\Initiative;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class InitiativeResource extends Resource
{
    protected static ?string $model = Initiative::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'Initiative Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Grid::make(2)
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Initiative Details')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Initiative Title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                        TextInput::make('slug')
                                            ->label('URL Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('This will be the URL of your initiative'),

                                        Select::make('category')
                                            ->label('Category')
                                            ->options([
                                                'education' => 'Education',
                                                'healthcare' => 'Healthcare',
                                                'infrastructure' => 'Infrastructure',
                                                'social_welfare' => 'Social Welfare',
                                                'economic_development' => 'Economic Development',
                                                'environment' => 'Environment',
                                                'youth' => 'Youth Programs',
                                                'women' => 'Women Empowerment',
                                                'elderly' => 'Elderly Care',
                                                'disability' => 'Disability Support',
                                                'other' => 'Other',
                                            ])
                                            ->required()
                                            ->searchable(),

                                        Textarea::make('short_description')
                                            ->label('Short Description')
                                            ->maxLength(300)
                                            ->rows(3)
                                            ->helperText('Brief description for listings and previews'),

                                        RichEditor::make('description')
                                            ->label('Full Description')
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'link',
                                                'bulletList',
                                                'orderedList',
                                                'h2',
                                                'h3',
                                                'h4',
                                                'blockquote',
                                                'undo',
                                                'redo',
                                            ])
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('initiatives')
                                            ->fileAttachmentsVisibility('public'),
                                    ]),

                                Section::make('Eligibility & Requirements')
                                    ->schema([
                                        RichEditor::make('eligibility_criteria')
                                            ->label('Eligibility Criteria')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                            ]),

                                        RichEditor::make('benefits')
                                            ->label('Benefits')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                            ]),

                                        RichEditor::make('requirements')
                                            ->label('Requirements')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                            ]),
                                    ]),

                                Section::make('Application Form Configuration')
                                    ->schema([
                                        KeyValue::make('application_form_data')
                                            ->label('Form Fields')
                                            ->keyLabel('Field Name')
                                            ->valueLabel('Field Type')
                                            ->addActionLabel('Add Field')
                                            ->keyPlaceholder('e.g., full_name')
                                            ->valuePlaceholder('e.g., text, email, textarea, select')
                                            ->helperText('Configure the application form fields for this initiative'),
                                    ])
                                    ->collapsible(),
                            ]),

                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Initiative Settings')
                                    ->schema([
                                        Select::make('status')
                                            ->label('Status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'active' => 'Active',
                                                'completed' => 'Completed',
                                                'cancelled' => 'Cancelled',
                                            ])
                                            ->default('draft')
                                            ->required(),

                                        DateTimePicker::make('application_deadline')
                                            ->label('Application Deadline')
                                            ->helperText('When applications will close'),

                                        DateTimePicker::make('start_date')
                                            ->label('Start Date')
                                            ->helperText('When the initiative begins'),

                                        DateTimePicker::make('end_date')
                                            ->label('End Date')
                                            ->helperText('When the initiative ends'),

                                        TextInput::make('max_applications')
                                            ->label('Maximum Applications')
                                            ->numeric()
                                            ->helperText('Leave empty for unlimited applications'),

                                        TextInput::make('current_applications')
                                            ->label('Current Applications')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->helperText('Automatically updated'),

                                        Toggle::make('is_featured')
                                            ->label('Featured Initiative')
                                            ->helperText('Featured initiatives appear prominently'),

                                        TextInput::make('order')
                                            ->label('Display Order')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Lower numbers appear first'),
                                    ]),

                                Section::make('Budget & Financial')
                                    ->schema([
                                        TextInput::make('budget_amount')
                                            ->label('Budget Amount (RM)')
                                            ->numeric()
                                            ->prefix('RM')
                                            ->helperText('Total budget allocated for this initiative'),

                                        TextInput::make('budget_used')
                                            ->label('Budget Used (RM)')
                                            ->numeric()
                                            ->prefix('RM')
                                            ->default(0)
                                            ->helperText('Amount spent so far'),
                                    ]),

                                Section::make('Contact Information')
                                    ->schema([
                                        TextInput::make('contact_person')
                                            ->label('Contact Person')
                                            ->maxLength(255),

                                        TextInput::make('contact_email')
                                            ->label('Contact Email')
                                            ->email()
                                            ->maxLength(255),

                                        TextInput::make('contact_phone')
                                            ->label('Contact Phone')
                                            ->tel()
                                            ->maxLength(255),

                                        TextInput::make('location')
                                            ->label('Location')
                                            ->maxLength(255)
                                            ->helperText('Where the initiative is based'),
                                    ]),

                                Section::make('Featured Image')
                                    ->schema([
                                        FileUpload::make('featured_image')
                                            ->label('Featured Image')
                                            ->image()
                                            ->imageEditor()
                                            ->imageCropAspectRatio('16:9')
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('675')
                                            ->directory('initiatives/featured')
                                            ->visibility('public')
                                            ->helperText('Recommended size: 1200x675 pixels'),
                                    ]),

                                Section::make('Notification Settings')
                                    ->schema([
                                        KeyValue::make('notification_settings')
                                            ->label('Notification Preferences')
                                            ->keyLabel('Setting')
                                            ->valueLabel('Value')
                                            ->addActionLabel('Add Setting')
                                            ->helperText('Configure notification preferences for this initiative'),
                                    ])
                                    ->collapsible(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular()
                    ->size(40),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color('primary'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'active',
                        'info' => 'completed',
                        'danger' => 'cancelled',
                    ]),

                TextColumn::make('current_applications')
                    ->label('Applications')
                    ->formatStateUsing(fn (Initiative $record): string => 
                        $record->current_applications . 
                        ($record->max_applications ? '/' . $record->max_applications : '')
                    )
                    ->sortable(),

                TextColumn::make('application_deadline')
                    ->label('Deadline')
                    ->dateTime()
                    ->sortable()
                    ->color(fn (Initiative $record): string => 
                        $record->application_deadline && $record->application_deadline->isPast() 
                            ? 'danger' 
                            : 'success'
                    ),

                TextColumn::make('budget_amount')
                    ->label('Budget')
                    ->money('MYR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                ToggleColumn::make('is_featured')
                    ->label('Featured'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'education' => 'Education',
                        'healthcare' => 'Healthcare',
                        'infrastructure' => 'Infrastructure',
                        'social_welfare' => 'Social Welfare',
                        'economic_development' => 'Economic Development',
                        'environment' => 'Environment',
                        'youth' => 'Youth Programs',
                        'women' => 'Women Empowerment',
                        'elderly' => 'Elderly Care',
                        'disability' => 'Disability Support',
                        'other' => 'Other',
                    ]),

                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Initiative $record): string => $record->full_url)
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-play')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'active']);
                            });
                        })
                        ->requiresConfirmation(),

                    BulkAction::make('complete')
                        ->label('Mark as Completed')
                        ->icon('heroicon-o-check-circle')
                        ->color('info')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'completed']);
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
            'index' => Pages\ListInitiatives::route('/'),
            'create' => Pages\CreateInitiative::route('/create'),
            'edit' => Pages\EditInitiative::route('/{record}/edit'),
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
        return static::getModel()::where('status', 'active')->count();
    }
}
