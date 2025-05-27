import { Address } from '@admin/shared/types/address';

export interface OrderDetailInterface {
  information: {
    id: number,
    uuid: string,
    cartToken: string,
    orderStatus: string,
    createdAt: string,
    updatedAt: string
  }
  contactDetails?: {
    email?: string,
    firstname?: string,
    lastname?: string,
    phone?: string | number,
  },
  deliveryAddress?: {
    address: Address,
    deliveryInstructions?: string
  },
  invoiceAddress?: {
    address: Address,
    companyName?: string,
    companyTaxId?: string | number,
  },
  shipping?: {
    id: number,
    name: string,
    fee: string,
  },
  payment?: {
    paymentMethod: string,
    paymentMethodCollection: {
      id: number,
      paidAt?: string,
      amount?: string,
      gatewayTransactionId?: string,
      paymentMethodName: string,
      paymentStatus: string,
    }[]
  },
  items?: {
    itemCollection?: {
      name?: string,
      imageUrl?: string,
      editUrl?: string,
      quantity: number,
      totalPrice: string,
      unitPrice: string
    }[]
  }
}
