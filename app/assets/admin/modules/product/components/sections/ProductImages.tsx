import React, { useEffect, useState } from 'react';
import FormSection from '@admin/shared/components/form/FormSection';
import { normalizeFiles } from '@admin/utils/helper';
import { useDropzoneLogic } from '@admin/hooks/useDropzoneLogic';
import ProductDropzoneThumbnail from '@admin/features/product/components/ProductDropzoneThumbnail';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import { UseFormSetValue } from 'react-hook-form';
import { ProductFormDataInterface } from '@admin/modules/product/interfaces/ProductFormDataInterface';
import { FileResponseInterface } from '@admin/shared/interfaces/FileResponseInterface';
import ProductDropzoneThumbnailList from '@admin/modules/product/components/ProductDropzoneThumbnailList';

interface ProductImagesProps {
  setValue: UseFormSetValue<ProductFormDataInterface>;
  formData?: ProductFormDataInterface;
}

interface ProductFileResponse extends FileResponseInterface {
  isThumbnail: boolean,
  type: string,
  uuid: string,
}


const ProductImages : React.FC<ProductImagesProps> = ({formData, setValue}) => {
  const [productImages, setProductImages] = useState<ProductFileResponse>([]);
  const maximumFiles = 5;

  useEffect(() => {
    if (formData?.images) {
      const normalizedImages = normalizeFiles(formData?.images);
      setProductImages(normalizedImages);
    }
  }, [formData?.images]);

  useEffect(() => {
    setValue('images', productImages);
  }, [productImages]);

  const setDropzoneValue = (newImages) => {
    setProductImages(newImages);
    setValue('images', newImages);
  };

  const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, null, productImages, maximumFiles);

  const setMainThumbnail = (file) => {
    setProductImages(prevProductImages =>
      prevProductImages.map((productImage) => ({
        ...productImage,
        isThumbnail: productImage.uuid === file.uuid,
      }))
    );
  };


  return (
    <FormSection title="Zdjęcia" >
      <div className="border border-gray-100 rounded-lg">
        <Dropzone onDrop={onDrop} errors={errors} containerClasses=" flex gap-5 p-5" variant="multiple">
          {productImages.length > 0 && (
            <ProductDropzoneThumbnailList
              setMainThumbnail={setMainThumbnail}
              files={productImages}
              setFiles={setProductImages}
              removeFile={removeFile}
            />
          )}
        </Dropzone>
      </div>

    </FormSection>
  )
}

export default ProductImages;
