<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->readOnly(),
                Forms\Components\DateTimePicker::make('paid_at')
                    ->native(false),
                Forms\Components\Select::make('status')
                    ->options(OrderStatus::class)
                    ->default(OrderStatus::Pending),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                \Filament\Tables\Columns\TextColumn::make('items_summary')
                    ->label('Products')
                    ->html()
                    ->formatStateUsing(function ($record) {
                        return collect($record->items)
                            ->map(fn($item) => "<span class='inline-block text-gray-700 text-sm'>" . Str::limit($item->product_name, 20) . " × " . $item->quantity . "</span>")
                            ->implode('<br>');
                    })
                    ->limit(3),

                \Filament\Tables\Columns\TextColumn::make('total_price')
                    ->money('VND', true)
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Ordered At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Order::make(),
            'active' => Order::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', true)),
            'inactive' => Order::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('active', false)),
        ];
    }

    public static function beforeSave($record): void
    {
        $record->total_price = $record->items->sum(fn($item) => $item->price * $item->quantity);
    }
}
