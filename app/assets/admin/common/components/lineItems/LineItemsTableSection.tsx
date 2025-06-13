import FormSection from '@admin/common/components/form/FormSection';
import React, { FC } from 'react';
import { LineItem } from '@admin/common/components/lineItems/LineItem';
import LineTableItem from '@admin/common/components/lineItems/LineTableItem';

interface LineItemsTableSectionProps {
    title: string;
    items?: LineItem[];
}

const LineItemsTableSection: FC<LineItemsTableSectionProps> = ({ title, items }) => (
    <FormSection title={title}>
        <table className="w-full border-seperate text-left">
            <thead>
                <tr className="text-xs uppercase text-gray-500">
                    <th className="py-2 px-4">Produkt</th>
                    <th className="py-2 px-4 text-center">Ilość</th>
                    <th className="py-2 px-4 text-right">Cena</th>
                    <th className="py-2 px-4 text-right">Suma</th>
                </tr>
            </thead>
            <tbody>{items?.map((item, key) => <LineTableItem key={key} item={item} />)}</tbody>
        </table>
    </FormSection>
);

export default LineItemsTableSection;
