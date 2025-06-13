import { Money } from '@admin/common/types/money';

export interface CarrierListItem {
    id: number;
    name: string;
    fee: Money;
    imagePath?: string;
    isActive: boolean;
}
