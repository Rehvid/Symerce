import { Money } from '@admin/common/types/money';

export interface ProductListItem {
    id: number;
    image?: string;
    isActive: boolean;
    name: string;
    quantity: number;
    showUrl: string;
    regularPrice: Money;
    discountedPrice?: Money;
}
