<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContributionResource\Pages;
use App\Filament\Admin\Resources\ContributionResource\RelationManagers;
use App\Models\Contribution;
use App\Models\Recipient;
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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\MoneyColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\DateRangeFilter;

class ContributionResource extends Resource
{
    protected static ?string $model = Contribution::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Contributions';
    protected static ?string $navigationGroup = 'Constituency Management';
    protected static ?string $pluralLabel = 'Contributions';
    protected static ?string $modelLabel = 'Contribution';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Recipient Information')
                    ->description('Details of the person receiving the contribution')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('recipient_ic')
                                    ->label('IC Number')
                                    ->placeholder('e.g., 901234567890')
                                    ->required()
                                    ->maxLength(12)
                                    ->unique(ignoreRecord: true)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if (strlen($state) >= 12) {
                                            $recipient = Recipient::where('ic_number', $state)->first();
                                            if ($recipient) {
                                                $set('recipient_name', $recipient->name);
                                                $set('recipient_phone', $recipient->phone);
                                                $set('recipient_address', $recipient->address);
                                            }
                                        }
                                    }),
                                TextInput::make('recipient_name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('recipient_phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                Textarea::make('recipient_address')
                                    ->label('Address')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(500),
                            ]),
                    ]),

                Section::make('Contribution Details')
                    ->description('Information about the contribution being made')
                    ->icon('heroicon-o-gift')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('amount')
                                    ->label('Amount (RM)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('RM')
                                    ->minValue(0)
                                    ->step(0.01),
                                
                                Select::make('category')
                                    ->label('Category')
                                    ->required()
                                    ->options([
                                        'Medical' => 'Medical',
                                        'Education' => 'Education',
                                        'Emergency' => 'Emergency',
                                        'Business' => 'Business',
                                        'Housing' => 'Housing',
                                        'Food' => 'Food',
                                        'Transport' => 'Transport',
                                        'Other' => 'Other',
                                    ])
                                    ->searchable(),
                                
                                Select::make('contribution_type')
                                    ->label('Contribution Type')
                                    ->required()
                                    ->options([
                                        'Cash' => 'Cash',
                                        'Cheque' => 'Cheque',
                                        'Bank Transfer' => 'Bank Transfer',
                                        'In-Kind' => 'In-Kind',
                                    ]),
                                
                                Select::make('payment_method')
                                    ->label('Payment Method')
                                    ->required()
                                    ->options([
                                        'cash' => 'Cash',
                                        'cheque' => 'Cheque',
                                        'bank_transfer' => 'Bank Transfer',
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state !== 'cheque') {
                                            $set('cheque_number', null);
                                        }
                                    }),
                                
                                TextInput::make('cheque_number')
                                    ->label('Cheque Number')
                                    ->visible(fn (callable $get) => $get('payment_method') === 'cheque')
                                    ->required(fn (callable $get) => $get('payment_method') === 'cheque'),
                                
                                DatePicker::make('contribution_date')
                                    ->label('Contribution Date')
                                    ->required()
                                    ->default(now())
                                    ->maxDate(now()),
                                
                                TextInput::make('location')
                                    ->label('Location')
                                    ->placeholder('e.g., Kampung Baru, Pilah')
                                    ->maxLength(255),
                                
                                TextInput::make('voucher_number')
                                    ->label('Voucher Number')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true),
                            ]),
                        
                        Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Brief description of the contribution and its purpose'),
                        
                        FileUpload::make('documents')
                            ->label('Supporting Documents')
                            ->multiple()
                            ->directory('contributions/documents')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(5120)
                            ->helperText('Upload receipts, photos, or other supporting documents'),
                    ]),

                Section::make('Administration')
                    ->description('Internal tracking and approval')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'disbursed' => 'Disbursed',
                            ])
                            ->default('pending')
                            ->colors([
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'disbursed' => 'info',
                            ]),
                        
                        Textarea::make('admin_notes')
                            ->label('Admin Notes')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Internal notes for tracking and reference'),
                    ])
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recipient_name')
                    ->label('Recipient')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('recipient_ic')
                    ->label('IC Number')
                    ->searchable()
                    ->sortable(),
                
                MoneyColumn::make('amount')
                    ->label('Amount')
                    ->currency('MYR')
                    ->sortable(),
                
                BadgeColumn::make('category')
                    ->label('Category')
                    ->colors([
                        'primary' => 'Medical',
                        'success' => 'Education',
                        'warning' => 'Emergency',
                        'info' => 'Business',
                        'secondary' => 'Housing',
                        'danger' => 'Food',
                        'gray' => 'Other',
                    ])
                    ->sortable(),
                
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'info' => 'disbursed',
                    ])
                    ->sortable(),
                
                TextColumn::make('contribution_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'Medical' => 'Medical',
                        'Education' => 'Education',
                        'Emergency' => 'Emergency',
                        'Business' => 'Business',
                        'Housing' => 'Housing',
                        'Food' => 'Food',
                        'Transport' => 'Transport',
                        'Other' => 'Other',
                    ]),
                
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'disbursed' => 'Disbursed',
                    ]),
                
                DateRangeFilter::make('contribution_date')
                    ->label('Contribution Date'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->action(fn ($records) => $records->each->update(['status' => 'approved']))
                        ->requiresConfirmation()
                        ->color('success'),
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
            'index' => Pages\ListContributions::route('/'),
            'create' => Pages\CreateContribution::route('/create'),
            'edit' => Pages\EditContribution::route('/{record}/edit'),
        ];
    }
}
