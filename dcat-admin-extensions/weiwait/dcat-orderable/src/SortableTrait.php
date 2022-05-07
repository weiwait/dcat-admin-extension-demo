<?php

namespace Weiwait\DcatOrderable;

use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use InvalidArgumentException;
use Spatie\EloquentSortable\Sortable;

trait SortableTrait
{
    public static function bootSortableTrait()
    {
        static::creating(function ($model) {
            if ($model instanceof Sortable && $model->shouldSortWhenCreating()) {
                $model->setHighestOrderNumber();
            }
        });
    }

    public function setHighestOrderNumber(): void
    {
        $orderColumnName = $this->determineOrderColumnName();

        $this->$orderColumnName = $this->getHighestOrderNumber() + 1;
    }

    public function getHighestOrderNumber(): int
    {
        return (int)$this->buildSortQuery()->max($this->determineOrderColumnName());
    }

    public function getLowestOrderNumber(): int
    {
        return (int)$this->buildSortQuery()->min($this->determineOrderColumnName());
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc')
    {
        return $query->orderBy($this->determineOrderColumnName(), $direction);
    }

    public static function setNewOrder($ids, int $startOrder = 1, string $primaryKeyColumn = null): void
    {
        if (!is_array($ids) && !$ids instanceof ArrayAccess) {
            throw new InvalidArgumentException('You must pass an array or ArrayAccess object to setNewOrder');
        }

        $model = new static();

        $orderColumnName = $model->determineOrderColumnName();

        if (is_null($primaryKeyColumn)) {
            $primaryKeyColumn = $model->getKeyName();
        }

        foreach ($ids as $id) {
            static::withoutGlobalScope(SoftDeletingScope::class)
                ->where($primaryKeyColumn, $id)
                ->update([$orderColumnName => $startOrder++]);
        }
    }

    public static function setNewOrderByCustomColumn(string $primaryKeyColumn, $ids, int $startOrder = 1)
    {
        self::setNewOrder($ids, $startOrder, $primaryKeyColumn);
    }

    public function determineOrderColumnName(): string
    {
        return $this->sortable['order_column_name']
            ?? $this->sortable['column']
            ?? config('eloquent-sortable.order_column_name', 'order_column');
    }

    /**
     * Determine if the order column should be set when saving a new model instance.
     */
    public function shouldSortWhenCreating(): bool
    {
        return $this->sortable['sort_when_creating']
            ?? $this->sortable['sortable']
            ?? config('eloquent-sortable.sort_when_creating', true);
    }

    public function moveOrderDown(): static
    {
        $orderColumnName = $this->determineOrderColumnName();

        $swapWithModel = $this->buildSortQuery()->limit(1)
            ->ordered()
            ->where($orderColumnName, '>', $this->$orderColumnName)
            ->first();

        if (!$swapWithModel) {
            return $this;
        }

        return $this->swapOrderWithModel($swapWithModel);
    }

    public function moveOrderUp(): static
    {
        $orderColumnName = $this->determineOrderColumnName();

        $swapWithModel = $this->buildSortQuery()->limit(1)
            ->ordered('desc')
            ->where($orderColumnName, '<', $this->$orderColumnName)
            ->first();

        if (!$swapWithModel) {
            return $this;
        }

        return $this->swapOrderWithModel($swapWithModel);
    }

    public function swapOrderWithModel(Sortable $otherModel): static
    {
        $orderColumnName = $this->determineOrderColumnName();

        $oldOrderOfOtherModel = $otherModel->$orderColumnName;

        $otherModel->$orderColumnName = $this->$orderColumnName;
        $otherModel->save();

        $this->$orderColumnName = $oldOrderOfOtherModel;
        $this->save();

        return $this;
    }

    public static function swapOrder(Sortable $model, Sortable $otherModel): void
    {
        $model->swapOrderWithModel($otherModel);
    }

    public function moveToStart(): static
    {
        $firstModel = $this->buildSortQuery()->limit(1)
            ->ordered()
            ->first();

        if ($firstModel->getKey() === $this->getKey()) {
            return $this;
        }

        $orderColumnName = $this->determineOrderColumnName();

        $this->$orderColumnName = $firstModel->$orderColumnName;
        $this->save();

        $this->buildSortQuery()->where($this->getKeyName(), '!=', $this->getKey())->increment($orderColumnName);

        return $this;
    }

    public function moveToEnd(): static
    {
        $maxOrder = $this->getHighestOrderNumber();

        $orderColumnName = $this->determineOrderColumnName();

        if ($this->$orderColumnName === $maxOrder) {
            return $this;
        }

        $oldOrder = $this->$orderColumnName;

        $this->$orderColumnName = $maxOrder;
        $this->save();

        $this->buildSortQuery()->where($this->getKeyName(), '!=', $this->getKey())
            ->where($orderColumnName, '>', $oldOrder)
            ->decrement($orderColumnName);

        return $this;
    }

    public function isLastInOrder(): bool
    {
        $orderColumnName = $this->determineOrderColumnName();

        return (int)$this->$orderColumnName === $this->getHighestOrderNumber();
    }

    public function isFirstInOrder(): bool
    {
        $orderColumnName = $this->determineOrderColumnName();

        return (int)$this->$orderColumnName === $this->getLowestOrderNumber();
    }

    public function buildSortQuery(): Builder
    {
        $restriction = $this->sortable['restriction'] ?? false;
        if ($this->$restriction) {
            return static::query()->where($restriction, $this->$restriction);
        }

        return static::query();
    }

    //自定义前进数跃进
    public function moveOrderAscend(int $ascend)
    {
        $ascend = $ascend > 0 ? $ascend : 1;

        $orderColumnName = $this->determineOrderColumnName();

        $direction = $this->sortable['direction'] ?? 'asc';

        if ('asc' == $direction) {
            if (!$target = $this->buildSortQuery()->orderByDesc($orderColumnName)->where($orderColumnName, '<', $this->$orderColumnName)->offset($ascend - 1)->first())
                if (!$target = $this->buildSortQuery()->where($orderColumnName, '<', $this->$orderColumnName)->orderBy($orderColumnName)->first())
                    return $this;

            if ($this->$orderColumnName == $target->$orderColumnName)
                return $this;

            $this->buildSortQuery()->orderByDesc($orderColumnName)->where($orderColumnName, '<', $this->$orderColumnName)->limit($ascend)->increment($orderColumnName);

            $this->$orderColumnName = $target->$orderColumnName;
            $this->save();

        } else {
            if (!$target = $this->buildSortQuery()->orderBy($orderColumnName)->where($orderColumnName, '>', $this->$orderColumnName)->offset($ascend - 1)->first())
                if (!$target = $this->buildSortQuery()->where($orderColumnName, '>', $this->$orderColumnName)->orderByDesc($orderColumnName)->first())
                    return $this;

            if ($this->$orderColumnName == $target->$orderColumnName)
                return $this;

            $this->buildSortQuery()->orderBy($orderColumnName)->where($orderColumnName, '>', $this->$orderColumnName)->limit($ascend)->decrement($orderColumnName);

            $this->$orderColumnName = $target->$orderColumnName;
            $this->save();
        }

        return $this;
    }

    //自定义下降数倒退
    public function moveOrderDescend(int $descend)
    {
        $descend = $descend > 0 ? $descend : 1;

        $orderColumnName = $this->determineOrderColumnName();

        $direction = $this->sortable['direction'] ?? 'asc';

        if ('asc' == $direction) {
            if (!$target = $this->buildSortQuery()->orderBy($orderColumnName)->where($orderColumnName, '>', $this->$orderColumnName)->offset($descend - 1)->first())
                if (!$target = $this->buildSortQuery()->orderByDesc($orderColumnName)->where($orderColumnName, '>', $this->$orderColumnName)->first())
                    return $this;

            if ($this->$orderColumnName == $target->$orderColumnName)
                return $this;

            $this->buildSortQuery()->orderBy($orderColumnName)->where($orderColumnName, '>', $this->$orderColumnName)->limit($descend)->decrement($orderColumnName);

            $this->$orderColumnName = $target->$orderColumnName;
            $this->save();

        } else {
            // 在降序中，大的靠前，要把自身排序降低那就是把排序数降低
            // 在所有小于自身排序数的条目中越靠近自身的条目排序数就越大，所以使用降序
            if (!$target = $this->buildSortQuery()->orderByDesc($orderColumnName)->where($orderColumnName, '<', $this->$orderColumnName)->offset($descend - 1)->first())
                // 因为offset找不到目标返回null，而当自身后面没有足够的条目时，就把自身放到最后面
                if (!$target = $this->buildSortQuery()->orderBy($orderColumnName)->where($orderColumnName, '<', $this->$orderColumnName)->first())
                    return $this;

            if ($this->$orderColumnName == $target->$orderColumnName)
                return $this;

            $this->buildSortQuery()->orderByDesc($orderColumnName)->where($orderColumnName, '<', $this->$orderColumnName)->limit($descend)->increment($orderColumnName);

            $this->$orderColumnName = $target->$orderColumnName;
            $this->save();
        }

        return $this;
    }

    //排序到指定位置
    public function moveOrderTo(int $to)
    {
        if ($to < 1)
            throw new PreconditionFailedHttpException('The position to move to must be a positive integer.');

        $orderColumnName = $this->determineOrderColumnName();

        $direction = $this->sortable['direction'] ?? 'asc';

        if ('asc' == $direction) {
            if (!$target = $this->buildSortQuery()->orderBy($orderColumnName)->offset($to - 1)->first())
                $target = $this->buildSortQuery()->orderByDesc($orderColumnName)->firstOrFail();
        } else {
            if (!$target = $this->buildSortQuery()->orderByDesc($orderColumnName)->offset($to - 1)->first())
                $target = $this->buildSortQuery()->orderBy($orderColumnName)->firstOrFail();
        }

        if ($this->$orderColumnName == $target->$orderColumnName)
            return $this;

        if ($this->$orderColumnName > $target->$orderColumnName) {
            $this->buildSortQuery()->whereBetween($orderColumnName, [$target->$orderColumnName, $this->$orderColumnName])->increment($orderColumnName);
        } else {
            $this->buildSortQuery()->whereBetween($orderColumnName, [$this->$orderColumnName, $target->$orderColumnName])->decrement($orderColumnName);
        }

        $this->$orderColumnName = $target->$orderColumnName;
        $this->save();

        return $this;
    }
}
