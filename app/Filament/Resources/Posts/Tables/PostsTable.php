<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("image")->disk("public"), // 要展示图片，第一次需要命令行执行 php artisan storage:link 链接好资源地址
                TextColumn::make("title")->sortable()->searchable(),
                TextColumn::make("slug")->sortable()->searchable(),
                TextColumn::make("category.name")->sortable()->searchable(), // 因为在 app/Models/Post 关联了 Category 表，所以可以这样操作
                ColorColumn::make("color"),
                TextColumn::make("created_at")
                ->label("Created At")
                ->datetime()
                ->sortable(),

            ])
            ->defaultSort("title","asc")
            ->filters([
                Filter::make("created_at")  // 1. 创建过滤器容器，created_at：对应数据库 created_at 字段
                    ->label("Creation date")
                    ->schema([
                        // 2. 在容器内放入一个日期选择器表单元素
                        DatePicker::make("created_at") // 创建一个日期选择器， created_at: 对应前端表单的 created_at 字段
                            ->label("Select Date:") // 提示语
                    ])
                    ->query(function($query, $data){
                        // 3. 获取 DatePicker 收集到的数据，执行数据库查询
                        return $query
                            ->when($data["created_at"], function($q, $date) { // when 判断前端是否传入日期，有则执行函数; $q: 查询构造器、 $date: 前端传入的数据
                                $q->whereDate("created_at", $date); // 查询， $q 跟 $query 是一个东西
                            });
                    }),
                SelectFilter::make("category_id")
                    ->label("Select Category")
                    // 取关联表（如 categories）中的 name 字段作为下拉菜单的选项
                    ->relationship("category", "name") // category 对应 Models文件夹下的 Post类中的 category 关联方法
                    ->preload() // 前把关联的选项数据从数据库查询出来渲染到前端
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
