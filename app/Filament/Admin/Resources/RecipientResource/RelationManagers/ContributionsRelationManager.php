<?php

namespace App\Filament\Admin\Resources\RecipientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContributionsRelationManager extends RelationManager
{
    protected static string $relationship = 'contributions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('RM'),
                Forms\Components\Select::make('category')
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
                    ]),
                Forms\Components\Select::make('contribution_type')
                    ->required()
                    ->options([
                        'Cash' => 'Cash',
                        'Cheque' => 'Cheque',
                        'Bank Transfer' => 'Bank Transfer',
                        'In-Kind' => 'In-Kind',
                    ]),
                Forms\Components\DatePicker::make('contribution_date')
                    ->required()
                    ->default(now()),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'primary' => 'Medical',
                        'success' => 'Education',
                        'warning' => 'Emergency',
                        'info' => 'Business',
                    ]),
                Tables\Columns\TextColumn::make('contribution_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('contribution_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}