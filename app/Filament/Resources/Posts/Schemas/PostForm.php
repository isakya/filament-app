<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("title"),
                TextInput::make("slug"),
                // Select::make("category_id")->options(["one", "two"]), // 选项示例
                Select::make("category_id")
                    ->label("Category") // 修改表单的label文案
                    ->options(Category::all()->pluck("name", "id")), // 查出 categories 表的所有记录，然后返回一个以 id 为键、name 为值的集合。
                ColorPicker::make("color"),
                MarkdownEditor::make("body"),
                FileUpload::make("image")->disk("public")->directory("posts"), // 上传文件路径指定，在 storage/app/public 文件夹下可以看到上传文件
                TagsInput::make("tags"),
                Checkbox::make("published"),
                DatePicker::make("published_at")
            ]);
    }
}
