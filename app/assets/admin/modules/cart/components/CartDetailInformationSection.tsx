import FormSection from '@admin/common/components/form/FormSection';
import LabelValue from '@admin/common/components/LabelValue';
import React, { FC } from 'react';
import { CartDetailData } from '@admin/modules/cart/interfaces/CartDetailData';

interface CartDetailInformationSectionProps {
    detailData: CartDetailData;
}

const CartDetailInformationSection: FC<CartDetailInformationSectionProps> = ({ detailData }) => {
    return (
        <FormSection title="Informacje" useDefaultGap={false} contentContainerClasses="gap-2">
            <LabelValue label="Id" value={detailData.id} />
            <LabelValue label="Klient" value={detailData.customer} />
            <LabelValue label="Data utworzenia" value={detailData.createdAt} />
            <LabelValue label="Ostatnia aktualizacja" value={detailData.updatedAt} />
            <LabelValue label="Koszyk ważny do" value={detailData.expiresAt} />
        </FormSection>
    );
};

export default CartDetailInformationSection;
