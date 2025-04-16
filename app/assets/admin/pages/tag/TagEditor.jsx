import { useParams } from 'react-router-dom';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import React from 'react';
import TagForm from '@/admin/features/tag/components/TagForm';

const TagEditor = () => {
  const params = useParams();

  return (
    <>
      <PageHeader title={params.id ? 'Edytuj' : 'Dodaj'}>
        <Breadcrumb />
      </PageHeader>
      <TagForm params={params} />
    </>
  )
}

export default TagEditor;
