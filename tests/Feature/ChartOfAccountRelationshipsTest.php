<?php

namespace Tests\Feature;

use App\Models\ChartOfAccount;
use App\Models\JournalDetail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ChartOfAccountRelationshipsTest extends TestCase
{
    public function test_chart_of_account_has_journal_details(): void
    {
        $relation = (new ChartOfAccount())->journalDetails();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertSame(JournalDetail::class, $relation->getRelated()::class);
        $this->assertSame('account_id', $relation->getForeignKeyName());
    }
}
