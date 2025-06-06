import React from 'react';
import Link from '@admin/common/components/Link';
import FormSection from '@admin/common/components/form/FormSection';

const ProductPriceHistoryBody = ({items}) => {
  return (
    <FormSection title="Historia">
      <table className="w-full border-seperate text-left">
        <thead>
        <tr className="text-xs uppercase text-gray-500">
          <th className="py-2 px-4">Identyfikator</th>
          <th className="py-2 px-4 text-center">Cena podstawowa</th>
          <th className="py-2 px-4 text-center">Cena promocyjna</th>
          <th className="py-2 px-4 text-right">Produkt</th>
          <th className="py-2 px-4 text-right">Data utworzenia</th>
        </tr>
        </thead>
        <tbody>
        {items.map(item => (
          <tr className="mb-3 text-sm odd:bg-gray-50">
            <td className="py-6 px-4">{item.id}</td>
            <td className="py-6 px-4 text-center">{item.basePrice}</td>
            <td className="py-6 px-4 text-center">{item.discountPrice}</td>
            <td className="py-6 px-4 text-right">
              <Link to={`/admin/products/${item.productId}/edit`} additionalClasses="text-center" >Produkt</Link>
            </td>
            <td className="py-6 px-4 text-right">{item.createdAt}</td>
          </tr>
        ))}

        </tbody>
      </table>
    </FormSection>
  )
}

export default ProductPriceHistoryBody;
