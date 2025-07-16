<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name') // nếu có quan hệ `product()`
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state && $product = Product::find($state)) {
                            $set('product_name', $product->name);
                            $set('product_sku', $product->sku);
                            $set('price', $product->price);
                            $set('product_image', $product->image); // Giả sử có cột image
                        } else {
                            $set('product_name', null);
                            $set('product_sku', null);
                            $set('price', null);
                            $set('product_image', null);
                        }
                    }),

                Forms\Components\TextInput::make('product_name')
                    ->label('Tên sản phẩm')
                    ->required()
                    ->disabled(), // không cho chỉnh sửa nếu tự động fill

                Forms\Components\Hidden::make('product_sku'),

                Forms\Components\TextInput::make('price')
                    ->label('Đơn giá')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Số lượng')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('total')
                    ->label('Thành tiền')
                    ->disabled()
                    ->afterStateHydrated(function (callable $set, $get) {
                        $set('total', $get('price') * $get('quantity'));
                    }),

                // Nếu muốn hiển thị hình ảnh dưới dạng preview:
                // \Filament\Forms\Components\ViewField::make('product_image')
                //     ->label('Ảnh sản phẩm')
                //     ->view('forms.components.image-preview')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
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
