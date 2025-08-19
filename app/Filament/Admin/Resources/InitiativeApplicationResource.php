<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InitiativeApplicationResource\Pages;
use App\Filament\Admin\Resources\InitiativeApplicationResource\RelationManagers;
use App\Models\InitiativeApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InitiativeApplicationResource extends Resource
{
    protected static ?string $model = InitiativeApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('initiative_id')
                    ->relationship('initiative', 'title')
                    ->required(),
                Forms\Components\Select::make('public_user_id')
                    ->relationship('publicUser', 'name')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('application_data')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('admin_notes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('user_notes')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('submitted_at'),
                Forms\Components\DateTimePicker::make('reviewed_at'),
                Forms\Components\TextInput::make('reviewed_by')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('approved_at'),
                Forms\Components\DateTimePicker::make('rejected_at'),
                Forms\Components\Textarea::make('rejection_reason')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('priority_score')
                    ->required()
                    ->numeric()
                    ->default(3),
                Forms\Components\Toggle::make('is_urgent')
                    ->required(),
                Forms\Components\TextInput::make('contact_preference')
                    ->required(),
                Forms\Components\Textarea::make('additional_documents')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('initiative.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publicUser.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rejected_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_urgent')
                    ->boolean(),
                Tables\Columns\TextColumn::make('contact_preference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListInitiativeApplications::route('/'),
            'create' => Pages\CreateInitiativeApplication::route('/create'),
            'edit' => Pages\EditInitiativeApplication::route('/{record}/edit'),
        ];
    }
}
