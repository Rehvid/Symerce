import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import React, { FC } from 'react';
import { DashboardOrderItem } from '@admin/modules/dashboard/interfaces/DashboardData';

interface DashboardOrderProps {
    orders: DashboardOrderItem[]
}

const DashboardOrder: FC<DashboardOrderProps> = ({orders}) => {
  return (
      <>
          <Heading level={HeadingLevel.H3} additionalClassNames="mb-[1.75rem]">Najnowsze zamówienia</Heading>
          <div className="w-full overflow-x-auto" >
              <table className="w-full border-seperate text-left table ">
                  <thead>
                  <tr className="text-xs uppercase text-gray-500">
                      <th className="py-2 px-4 text-left">Klient</th>
                      <th className="py-2 px-4">Produkty</th>
                      <th className="py-2 px-4">Suma</th>
                      <th className="py-2 px-4 text-right">Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  {orders?.map((order, key) => (
                      <tr className="odd:bg-gray-50 mb-3" key={key}>
                          <td className="py-2 px-4 text-sm text-left whitespace-nowrap">{order.customer}</td>
                          <td className="py-2 px-4 text-sm">
                              <div className="flex gap-1 flex-wrap ">
                                  {order.products?.map((product, key) => (
                                      <a
                                          href={product.showUrl}
                                          className="hover:text-black transition-colors text-gray-500 text-sm"
                                          target="_blank"
                                          rel="noopener noreferrer"
                                          title="Zobacz szczegóły"
                                          aria-label="Zobacz szczegóły"
                                      >
                                          {product.name} ({product.count}) {key < order.products.length - 1 ? ', ' : ''}
                                      </a>
                                  ))}
                              </div>
                          </td>
                          <td className="py-2 px-4 text-sm whitespace-nowrap">{order.total}</td>
                          <td className="py-2 px-4 text-sm text-right whitespace-nowrap">{order.status}</td>
                      </tr>
                  ))}
                  </tbody>
              </table>
          </div>

      </>
  )
};

export default DashboardOrder;
