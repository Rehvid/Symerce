import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import AttributeForm from '@/admin/features/product/attribute/components/AttributeForm';

const AttributeEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edytuj Attrybut' : 'Dodaj Attrybut'}>
        <Breadcrumb />
      </PageHeader>
      <AttributeForm params={params} />
    </>
  );
}

export default AttributeEditor;
