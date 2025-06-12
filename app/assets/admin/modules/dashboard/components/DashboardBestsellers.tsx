import Heading, { HeadingLevel } from '@admin/common/components/Heading';
import React, { FC } from 'react';
import ProductIcon from '@/images/icons/assembly.svg';
import { DashboardBestsellerItem } from '@admin/modules/dashboard/interfaces/DashboardData';

interface DashboardBestsellersProps {
    bestsellers: DashboardBestsellerItem[]
}

const DashboardBestsellers: FC<DashboardBestsellersProps> = ({bestsellers}) => {
  return (
      <>
          <Heading additionalClassNames="mb-[1.75rem]" level={HeadingLevel.H3}>Najlepiej sprzedające się produkty</Heading>
          <div className="w-full overflow-x-auto">
              <table className="w-full border-seperate text-left ">
                  <thead>
                  <tr className="text-xs uppercase text-gray-500">
                      <th className="py-2 px-4 text-left">Produkt</th>
                      <th className="py-2 px-4">Nazwa</th>
                      <th className="py-2 px-4">Kategoria</th>
                      <th className="py-2 px-4">Magazyn</th>
                      <th className="py-2 px-4 text-right"> Ilość </th>
                  </tr>
                  </thead>
                  <tbody>
                  {bestsellers?.map((bestseller, key) => (
                      <tr className="odd:bg-gray-50 mb-3" key={key}>
                          <td className="py-2 px-4 text-sm text-left whitespace-nowrap">
                              {bestseller.productImage ? (
                                  <img
                                      src={bestseller.productImage}
                                      alt="Image"
                                      className="w-12 h-12 rounded-full object-cover"
                                  />
                              ) : (
                                  <div className="w-12 h-12 flex items-center justify-center bg-primary-light rounded-full">
                                      <ProductIcon />
                                  </div>
                              )}
                          </td>
                          <td className="py-2 px-4 text-sm">{bestseller.productName}</td>
                          <td className="py-2 px-4 text-sm whitespace-nowrap">{bestseller.mainCategory}</td>
                          <td className="py-2 px-4 text-sm whitespace-nowrap">
                              {bestseller.isInStock
                                  ? (
                                      <span className="inline-flex items-center px-2.5 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                         W magazynie
                                      </span>
                                  ) : (
                                    <span className="inline-flex items-center px-2.5 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">Brak</span>
                                )
                              }
                          </td>
                          <td className="py-2 px-4 text-sm whitespace-nowrap text-right">{bestseller.totalSold}</td>
                      </tr>
                  ))}
                  </tbody>
              </table>
          </div>

      </>
  )
};

export default DashboardBestsellers;
