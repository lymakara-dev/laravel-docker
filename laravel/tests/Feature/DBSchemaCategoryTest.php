<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use Exception;

class DBSchemaCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('categories', [
                'id',
                'name',
                'created_at',
                'updated_at'
            ]),
            'Categories table does not have expected columns.'
        );
    }

    public function test_name_column_cannot_be_null()
    {

        $this->expectException(QueryException::class);
        Category::create([
            'name' => null,
        ]);
    }

}
