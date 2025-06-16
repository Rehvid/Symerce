<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Common\Domain\Entity\ProductStock;
use App\Common\Domain\Entity\Warehouse;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Common\Domain\ValueObject\DateVO;
use App\Product\Application\Dto\ProductDataStock;
use App\Warehouse\Domain\Repository\WarehouseRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ProductDataStockFactory
{
    public function __construct(
        private WarehouseRepositoryInterface $warehouseRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<int, array<string, mixed>> $stocks
     *
     * @return ProductDataStock[]
     */
    public function createFromArray(array $stocks): array
    {
        $warehouseIds = $this->extractWarehouseIds($stocks);
        $warehousesById = $this->fetchWarehousesById($warehouseIds);

        return array_map(
            fn (array $stock) => $this->createProductDataStock($stock, $warehousesById),
            $stocks
        );
    }

    /**
     * @param array<int, array<string, mixed>> $stocks
     *
     * @return int[]
     */
    private function extractWarehouseIds(array $stocks): array
    {
        return array_map(
            fn (array $stock) => (int) $stock['warehouseId'],
            $stocks
        );
    }

    /**
     * @param int[] $warehouseIds
     *
     * @return array<int|string, Warehouse>
     */
    private function fetchWarehousesById(array $warehouseIds): array
    {
        $warehouses = $this->warehouseRepository->findBy(['id' => $warehouseIds]);

        $indexed = [];
        foreach ($warehouses as $warehouse) {
            $indexed[$warehouse->getId()] = $warehouse;
        }

        return $indexed;
    }

    /**
     * @param array<string, mixed>         $stock
     * @param array<int|string, Warehouse> $warehousesById
     */
    private function createProductDataStock(array $stock, array $warehousesById): ProductDataStock
    {
        $warehouseId = (int) $stock['warehouseId'];
        $warehouse = $warehousesById[$warehouseId] ?? null;

        if (!$warehouse) {
            throw EntityNotFoundException::for(Warehouse::class, $warehouseId);
        }


        return new ProductDataStock(
            productStock: $this->entityManager->getRepository(ProductStock::class)->findOneBy(['id' => null]),
            availableQuantity: (int) $stock['availableQuantity'],
            warehouse: $warehouse,
            ean13: $this->castNullableInt($stock['ean13']),
            sku: $this->castNullableInt($stock['sku']),
            lowStockThreshold: $this->castNullableInt($stock['lowStockThreshold']),
            maximumStockLevel: $this->castNullableInt($stock['maximumStockLevel']),
            restockDate: $this->castNullableDateVO($stock['restockDate'] ?? null),
        );
    }

    private function castNullableInt(string|int|null $value): ?int
    {
        return '' === $value || null === $value ? null : (int) $value;
    }

    private function castNullableDateVO(?string $value): ?DateVO
    {
        return $value ? new DateVO($value) : null;
    }
}
