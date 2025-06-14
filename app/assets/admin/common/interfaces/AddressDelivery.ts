export interface AddressDelivery {
    city: string;
    countryId: number;
    postalCode: string;
    street: string;
    deliveryInstructions?: string | null;
}
