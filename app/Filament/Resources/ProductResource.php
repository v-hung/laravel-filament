<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Helpers\Filament;
use App\Helpers\Filament\FormHelper;

class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->rules(fn(string $locale) => [
                        Rule::unique('posts', "slug->$locale")
                            ->ignore(fn($record) => $record?->id),
                    ]),
                Forms\Components\Textarea::make('description')
                    ->label(FormHelper::localizedLabel("description"))
                    ->maxLength(255),
                Forms\Components\FileUpload::make('images')
                    ->label(FormHelper::localizedLabel("images"))
                    ->multiple(),
                Forms\Components\RichEditor::make('content')
                    ->label(FormHelper::localizedLabel("content"))
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->default(0)
                    ->readOnly(),
                Forms\Components\TextInput::make('stock_quantity')
                    ->numeric()
                    ->default(1)
                    ->readOnly(),
                Forms\Components\Select::make('status')
                    ->options(ProductStatus::class)
                    ->default(ProductStatus::Active),
                // \Filament\Infolists\Components\ImageEntry::make('product_image')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getTranslatableLocales(): array
    {
        return ['vi', 'en'];
    }
}
