export interface LineItem {
    name: string;
    editUrl?: string | null;
    imageUrl?: string | null;
    quantity: number;
    unitPrice: string;
    totalPrice: string;
}
