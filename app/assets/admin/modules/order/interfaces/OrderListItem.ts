import { Money } from '@admin/common/types/money';

export interface OrderListItem {
    id: number;
    status?: string;
    checkoutStep?: string;
    totalPrice?: Money;
    createdAt?: string;
    updatedAt: ?string;
}
