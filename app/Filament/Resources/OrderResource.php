<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pesanan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Pelanggan')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->disabled(), // Tidak bisa diubah

                                Select::make('table_id')
                                    ->label('Meja')
                                    ->relationship('table', 'name')
                                    ->searchable()
                                    ->disabled(),

                                TextInput::make('total_price')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->disabled(),

                                TextInput::make('status')
                                    ->disabled(),

                                Textarea::make('notes')
                                    ->columnSpanFull()
                                    ->disabled(),
                            ])
                    ]),

                Section::make('Item yang Dipesan')
                    ->schema([
                        // Placeholder untuk menampilkan detail item.
                        Placeholder::make('items_placeholder')
                            ->label('Detail Items')
                            ->content(function ($record) {
                                if (!$record || !$record->items) {
                                    return 'Tidak ada item.';
                                }
                                $html = '<ul>';
                                foreach ($record->items as $item) {
                                    $html .= '<li>' . $item->quantity . 'x ' . $item->menu->name . ' @ ' . number_format($item->price) . '</li>';
                                }
                                $html .= '</ul>';
                                return new \Illuminate\Support\HtmlString($html);
                            }),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom ID Pesanan
                TextColumn::make('order_number')
                    ->label('Order ID')
                    ->searchable(),

                // Kolom Nama Pelanggan (dari relasi)
                TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->default('Walk-in Customer'), // Teks jika user_id null

                // Kolom Nomor Meja (dari relasi)
                TextColumn::make('table.name')
                    ->label('Meja')
                    ->searchable()
                    ->sortable(),

                // Kolom Status dengan badge berwarna
                BadgeColumn::make('status')
                    ->colors([
                        'primary',
                        'warning' => 'diproses',
                        'success' => 'siap_disajikan',
                        'danger' => 'dibatalkan',
                        'gray' => 'menunggu_pembayaran',
                    ]),

                // Kolom Total Harga dengan format Rupiah
                TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->sortable()
                    // Menjumlahkan total harga di kaki tabel
                    ->summarize(Sum::make()->money('IDR')->label('Total Omset')),

                // Kolom Waktu Pemesanan
                TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan Status Pesanan
                SelectFilter::make('status')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'siap_disajikan' => 'Siap Disajikan',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),

                // Filter berdasarkan rentang tanggal
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Dari Tanggal'),
                        DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
}
