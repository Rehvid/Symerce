import { FormDataInterface } from '@admin/common/interfaces/FormDataInterface';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import { MetaFieldsInterface } from '@admin/common/components/form/fields/formGroup/MetaFields';
import { SlugInterface } from '@admin/common/components/form/fields/formGroup/Slug';

interface Stock {
    availableQuantity: number;
    lowStockThreshold: number;
    maximumStockLevel: number;
    ean13: string;
    sku: string;
    warehouseId: number;
    restockDate?: string | null;
}

export interface AttributeItem {
    isCustom: boolean;
    value: any;
}

export interface ProductImage extends UploadFile {
    isThumbnail: boolean;
}

export interface ProductFormData extends FormDataInterface, MetaFieldsInterface, SlugInterface {
    id: number | null;
    name: string;
    brand: number;
    description?: string;
    customAttributes: any;
    attributes: Record<string, AttributeItem[]>;
    isActive: boolean;
    mainCategory: number;
    categories?: number[];
    tags?: number[];
    vendor: number;
    deliveryTime: number;
    regularPrice: string;
    promotionIsActive?: boolean;
    promotionDateRange?: Date[];
    promotionReduction?: string;
    promotionReductionType?: number;
    promotionSource: string;
    stockAvailableQuantity: number;
    stockLowStockThreshold?: null | number;
    stockMaximumStockLevel?: null | number;
    stockEan13?: null | number;
    stockSku?: null | number;
    stockNotifyOnLowStock?: boolean;
    stockVisibleInStore?: boolean;
    stocks: Stock[];
    images: ProductImage[];
}
