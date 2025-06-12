export interface DashboardOrderItem {
    customer: string;
    status: string;
    total: string;
    products: DashboardOrderItemProduct[];
}

export interface DashboardOrderItemProduct {
    name: string;
    count: number;
    showUrl: string;
}

export interface DashboardBestsellerItem {
    isInStock: boolean;
    mainCategory?: string;
    productImage?: string;
    productName?:string;
    totalSold: number;
}

export interface DashboardData {
    customersCount: number;
    ordersCount: number;
    productsCount: number;
    activeCartsCount: number;
    orders: DashboardOrderItem[];
    bestSellers: DashboardBestsellerItem[];
}
