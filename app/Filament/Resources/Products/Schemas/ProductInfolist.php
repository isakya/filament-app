<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make("Tabs")
                    ->tabs([
                        Tab::make("Product Info")
                            ->icon(Heroicon::AcademicCap)
                            ->schema([
                                TextEntry::make("id")
                                    ->label("Product ID")
                                    ->weight("bold")
                                    ->color("primary"),
                                TextEntry::make("name") // 对应数据库的一个字段
                                    ->label("Product Nmae") // 为字段添加一个前端页面标题
                                    ->weight("bold") // 字重
                                    ->color("primary"), // 字体颜色
                                TextEntry::make("sku")
                                    ->label("Product SKU")
                                    ->weight("bold")
                                    ->badge()
                                    ->color("success"),
                                TextEntry::make("description")
                                    ->label("Product Description")
                                    ->weight("bold")
                                    ->color("primary"),
                                TextEntry::make("created_at")
                                    ->label("Product Creation Date")
                                    ->weight("bold")
                                    ->color("info")
                                    ->date("m/d/Y")
                            ]),
                        Tab::make("Pricing & Stock")
                            ->icon(Heroicon::CurrencyDollar)
                            ->badge(10)
                            ->badgeColor("info")
                            ->schema([
                                TextEntry::make("price")
                                    ->label("Product Price")
                                    ->weight("bold")
                                    ->icon(Heroicon::CurrencyDollar)
                                    ->color("primary"),
                                TextEntry::make("stock")
                                    ->label("Product Stock")
                                    ->weight("bold")
                                    ->color("primary")
                        ]),
                        Tab::make("Media & Status")
                            ->icon(Heroicon::Photo)
                            ->schema([
                                ImageEntry::make("image")
                                    ->label("Product Image")
                                    ->disk("public"),
                                IconEntry::make("is_active")
                                    ->label("Is Active?")
                                    ->boolean(),
                                IconEntry::make("is_featured")
                                    ->label("Is Featured?")
                                    ->boolean(),
                        ]),
                    ])->columnSpanFull()->vertical() // vertical 左边切换按钮，右边展示面板
            ]);
    }
}
