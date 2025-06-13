import CartDetailInformationSection from '@admin/modules/cart/components/CartDetailInformationSection';
import { CartDetailData } from '@admin/modules/cart/interfaces/CartDetailData';
import { FC } from 'react';
import LineItemsTableSection from '@admin/common/components/lineItems/LineItemsTableSection';

interface CartDetailBodyProps {
    detailData: CartDetailData;
}

const CartDetailBody: FC<CartDetailBodyProps> = ({ detailData }) => {
    return (
        <div className="mt-4 w-full flex-1 lg:mt-0">
            <CartDetailInformationSection detailData={detailData} />
            {detailData.items.length > 0 && <LineItemsTableSection title="Produkty" items={detailData.items} />}
        </div>
    );
};

export default CartDetailBody;
