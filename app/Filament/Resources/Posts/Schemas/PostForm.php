<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Fields")
                    ->description("Fill all the fields") // 该区块的描述
                    ->icon(Heroicon::RocketLaunch) // 该区块的图标
                    ->schema([ // Section layout 分区，分为单独一个区块
                        Group::make()
                            ->schema([
                                TextInput::make("title")
                                    // ->rule("required"), // 必填项 单个为 rule
                                    // ->rules("required|min:3"), // 多个为 rules
                                    ->rules(["required", "min:3", "max:10"]), // 也可以通过数组传递参数
                                TextInput::make("slug")
                                    // ->required(), // 出现必填 * 号提示
                                    ->unique() // 通过查询数据库判断是否为唯一值
                                    ->validationMessages([ // 验证提示信息
                                        "unique" => "slug should be unique."
                                    ]),

                                // Select::make("category_id")->options(["one", "two"]), // 选项示例
                                Select::make("category_id")
                                    ->label("Category") // 修改表单的label文案
                                    ->options(Category::all()->pluck("name", "id")), // 查出 categories 表的所有记录，然后返回一个以 id 为键、name 为值的集合。
                                ColorPicker::make("color"),
                            ])->columns(2),
                        MarkdownEditor::make("body"),
                    ])->columnSpan(2), // 3列中占2列的宽度,
                    // ->columnSpanFull(), // columnSpanFull 当前Section全宽展示

                Group::make() // Group 分组，让两个Section绑定在一起展示，相当于一个Section，这样就不会自动换行
                    ->schema([
                        Section::make("Image Upload")
                        ->schema([
                            FileUpload::make("image")->disk("public")->directory("posts"), // 上传文件路径指定，在 storage/app/public 文件夹下可以看到上传文件
                        ]),
                        Section::make("Meta")
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DatePicker::make("published_at")
                        ]),
                    ])->columnSpan(1) // 3列中占1列的宽度

            ])->columns(3); // columns 表单 layout n列 排布
    }
}
