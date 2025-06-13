import Link from '@admin/common/components/Link';
import { FC } from 'react';
import { LineItem } from '@admin/common/components/lineItems/LineItem';

interface LineTabelItemProps {
    item: LineItem;
}

const LineTableItem: FC<LineTabelItemProps> = ({ item }) => (
    <tr className="mb-3 text-sm odd:bg-gray-50">
        <td className="py-6 px-4">
            {item.editUrl ? (
                <Link to={item.editUrl} additionalClasses="font-bold">
                    {item.name}
                </Link>
            ) : (
                <span>{item.name}</span>
            )}
        </td>
        <td className="py-6 px-4 text-center">{item.quantity}</td>
        <td className="py-6 px-4 text-right">{item.unitPrice}</td>
        <td className="py-6 px-4 text-right">{item.totalPrice}</td>
    </tr>
);

export default LineTableItem;
