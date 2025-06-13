export interface ProductPriceHistory {
    id: number;
    createdAt: string;
    productId: number;
    basePrice: string;
    discountPrice?: string;
}
