import React, { useEffect, useState } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { normalizeFiles } from '@admin/common/utils/helper';
import { useDropzoneLogic } from '@admin/common/hooks/form/useDropzoneLogic';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import { UseFormSetValue } from 'react-hook-form';
import { ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import { FileResponseInterface } from '@admin/common/interfaces/FileResponseInterface';
import ProductDropzoneThumbnailList from '@admin/modules/product/components/ProductDropzoneThumbnailList';

interface ProductImagesProps {
  setValue: UseFormSetValue<ProductFormData>;
  formData?: ProductFormData;
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
