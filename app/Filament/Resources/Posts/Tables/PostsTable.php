<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("image")->disk("public"), // 要展示图片，第一次需要命令行执行 php artisan storage:link 链接好资源地址
                TextColumn::make("title")->sortable(),
                TextColumn::make("slug")->sortable(),
                TextColumn::make("category.name")->sortable(), // 因为在 app/Models/Post 关联了 Category 表，所以可以这样操作
                ColorColumn::make("color"),
                TextColumn::make("created_at")
                ->label("Created At")
                ->datetime()
                ->sortable(),

            ])
            ->defaultSort("title","asc")
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
