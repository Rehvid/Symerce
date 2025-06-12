import { LineItem } from '@admin/common/components/lineItems/LineItem';

export interface CartDetailData {
    items: LineItem[];
    createdAt: string;
    updatedAt: string;
    expiresAt: string;
    customer?: string | null;
    id: number | string | null;
}
