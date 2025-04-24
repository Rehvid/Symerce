import Input from '@/admin/components/form/controls/Input';
import { validationRules } from '@/admin/utils/validationRules';
import { Controller } from 'react-hook-form';
import Textarea from '@/admin/components/form/controls/Textarea';
import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import { normalizeFiles } from '@/admin/utils/helper';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import ModalFile from '@/admin/components/modal/ModalFile';
import Heading from '@/admin/components/common/Heading';
import { useState } from 'react';

const ProductFormMainColumn = ({register, fieldErrors, control, formData, setValue}) => {
  const [productImages, setProductImages] = useState(normalizeFiles(formData?.images))

  const setDropzoneValue = (image) => {
    setProductImages((prevImages) => {
      const existingImages = prevImages || [];
      const updatedImages = [...existingImages, ...image];

      setValue('images', updatedImages);

      return updatedImages;
    })
  };


  const maxValues = 5;
  const { onDrop, errors, removeFile } = useDropzoneLogic(
    setDropzoneValue,
    null,
    productImages,
    maxValues
  );

  return (
    <>
      <Input
        {...register('name', {
          ...validationRules.required(),
          ...validationRules.minLength(3),
        })}
        type="text"
        id="name"
        label="Nazwa"
        hasError={!!fieldErrors?.name}
        errorMessage={fieldErrors?.name?.message}
        isRequired
      />

      <div>
        <Heading level="h4">
          <span className="flex items-center mb-2">Zdjęcia </span>
        </Heading>
        <Dropzone onDrop={onDrop} errors={errors}>
          {productImages.length > 0 &&
            <div className="grid grid-cols-3 gap-5 mt-5">
              {productImages.map((file, key) => (
                <div className="relative flex h-full w-full rounded-lg border border-gray-200 p-2 " key={key}>
                  <img
                    className="rounded-lg mx-auto object-cover w-full"
                    src={file.preview}
                    alt={file.name}
                  />
                  <div className="absolute rounded-lg transition-all w-full h-full inset-0 flex items-center justify-center gap-3 hover:backdrop-blur-xl">
                    <DropzonePreviewActions
                      renderModal={() => <ModalFile preview={file.preview} name={file.name} />}
                      removeFile={removeFile}
                      file={file}
                    />
                  </div>
                </div>
              ))}
            </div>
          }
        </Dropzone>
      </div>


      <Input
        {...register('slug')}
        type="text"
        id="slug"
        label="Przyjazny url"
        hasError={!!fieldErrors?.slug}
        errorMessage={fieldErrors?.slug?.message}
      />

      <Controller
        name="description"
        control={control}
        defaultValue=""
        render={({ field }) => <Textarea value={field.value} onChange={field.onChange} title="Opis" />}
      />

      <Input
        {...register('regularPrice', {
          ...validationRules.required(),
          ...validationRules.numeric(2),
        })}
        type="text"
        id="regular-price"
        label="Cena regularna"
        hasError={!!fieldErrors?.regularPrice}
        errorMessage={fieldErrors?.regularPrice?.message}
        isRequired
      />

      <Input
        {...register('discountPrice', {
          ...validationRules.numeric(2),
        })}
        type="text"
        id="discountPrice"
        label="Cena promocyjna"
        hasError={!!fieldErrors?.discountPrice}
        errorMessage={fieldErrors?.discountPrice?.message}
      />

      <Input
        {...register('quantity', {
          ...validationRules.required(),
          ...validationRules.min(0),
        })}
        type="number"
        id="quantity"
        label="Ilość"
        hasError={!!fieldErrors?.quantity}
        errorMessage={fieldErrors?.quantity?.message}
        isRequired
      />
    </>
  )
}

export default ProductFormMainColumn;
