import CartDetailItemsSection from '@admin/modules/cart/components/section/CartDetailItemsSection';
import CartDetailInformationSection from '@admin/modules/cart/components/section/CartDetailInformationSection';

const CartDetailBody = ({items}) => {
  return (
    <div className="mt-4 w-full flex-1 lg:mt-0">
      <CartDetailInformationSection item={items} />
      {items.items.length > 0 && (
        <CartDetailItemsSection items={items.items}  />
      )}

    </div>
  )
}

export default CartDetailBody;
