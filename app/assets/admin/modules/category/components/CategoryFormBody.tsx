import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import FormGroup from '@admin/common/components/form/FormGroup';
import React, { useState } from 'react';
import { useDropzoneLogic } from '@admin/common/hooks/form/useDropzoneLogic';
import { UploadFileInterface } from '@admin/common/interfaces/UploadFileInterface';
import { normalizeFiles } from '@admin/common/utils/helper';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import { Controller } from 'react-hook-form';
import RichTextEditor from '@admin/common/components/form/input/RichTextEditor';
import FormCategoryTree from '@admin/components/category-tree/FormCategoryTree';
import FormSection from '@admin/common/components/form/FormSection';


const CategoryFormBody = ({register, fieldErrors, control, formData, formContext, params, watch, setValue}) => {
  const [thumbnail, setThumbnail] = useState<any>(normalizeFiles(formData?.thumbnail));


  const setDropzoneValue = (image: UploadFileInterface) => {
    setValue('thumbnail', image);
    setThumbnail(image);
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, thumbnail);

 return (
   <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
     <FormGroup  label={<InputLabel label="Miniaturka"  />} >
       <Dropzone onDrop={onDrop} errors={errors} containerClasses="relative max-w-lg" variant="mainColumn">
         {thumbnail.length > 0 &&
           thumbnail.map((file, key) => (
             <DropzoneThumbnail file={file} removeFile={removeFile} variant="single" key={key} index={key} />
           ))}
       </Dropzone>
     </FormGroup>

     <FormGroup
       label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name"  />}
     >
       <InputField
         type="text"
         id="name"
         hasError={!!fieldErrors?.name}
         errorMessage={fieldErrors?.name?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('name', {
           ...validationRules.required(),
           ...validationRules.minLength(2),
         })}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Slug" htmlFor="slug"  />}
     >
       <InputField
         type="text"
         id="slug"
         hasError={!!fieldErrors?.slug}
         errorMessage={fieldErrors?.slug?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('slug')}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Meta tytuł" htmlFor="metaTitle"  />}
     >
       <InputField
         type="text"
         id="metaTitle"
         hasError={!!fieldErrors?.metaTitle}
         errorMessage={fieldErrors?.metaTitle?.message}
         icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
         {...register('metaTitle')}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Meta opis" htmlFor="metaDescription"  />}
     >
       <textarea {...register('metaDescription')} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
     </FormGroup>

     <FormGroup
       label={<InputLabel label="Opis" htmlFor="description" />}
     >
       <Controller
         name="description"
         id="description"
         control={control}
         defaultValue=""
         render={({ field }) => <RichTextEditor value={field.value ?? ''} onChange={field.onChange} />}
       />
     </FormGroup>

     <FormGroup
       label={<InputLabel isRequired={true} label="Kategoria nadrzędna"   />}
     >
       {formContext?.tree && formContext?.tree?.length > 0 && (
         <FormCategoryTree
           hasError={!!fieldErrors?.parentCategoryId}
           errorMessage={fieldErrors?.parentCategoryId?.message}
           register={register('parentCategoryId')}
           disabledCategoryId={params.id ?? null}
           categories={formContext.tree || []}
           selected={formData?.parentCategoryId}
           watch={watch}
           nameWatchedValue="parentCategoryId"
         />
       )}

     </FormGroup>


     <FormGroup label={ <InputLabel label="Aktywny?" /> }>
       <Switch {...register('isActive')} />
     </FormGroup>

   </FormSection>
 );
}

export default CategoryFormBody;
