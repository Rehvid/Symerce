import FormSection from '@admin/shared/components/form/FormSection';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import Description from '@admin/shared/components/Description';
import CurrencyIcon from '@/images/icons/currency.svg';
import Switch from '@admin/shared/components/form/input/Switch';
import React, { useState } from 'react';
import { useData } from '@admin/hooks/useData';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import { normalizeFiles } from '@admin/utils/helper';
import { useDropzoneLogic } from '@admin/hooks/useDropzoneLogic';
import { UploadFileInterface } from '@admin/shared/interfaces/UploadFileInterface';

const PaymentMethodInformationSection = ({register, fieldErrors, formData, setValue}) => {
  const { currency } = useData();
  const [thumbnail, setThumbnail] = useState<any>(normalizeFiles(formData?.thumbnail))

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
            ...validationRules.minLength(3),
          })}
        />
      </FormGroup>
      <FormGroup
        label={<InputLabel isRequired={true} label="Kod" htmlFor="code"  />}
        description={<Description>Unikatowa nazwa widoczna tylko w panelu.</Description>}
      >
        <InputField
          type="text"
          id="code"
          hasError={!!fieldErrors?.code}
          errorMessage={fieldErrors?.code?.message}
          icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('code', {
            ...validationRules.required(),
          })}
        />
      </FormGroup>

      <FormGroup
        label={<InputLabel isRequired={true} label="Prowizja" htmlFor="fee"  />}
      >
        <InputField
          type="text"
          id="fee"
          hasError={!!fieldErrors?.fee}
          errorMessage={fieldErrors?.fee?.message}
          icon={<CurrencyIcon className="text-gray-500 w-[16px] h-[16px]" />}
          {...register('fee', {
            ...validationRules.required(),
            ...validationRules.numeric(currency.roundingPrecision),
          })}
        />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Aktywny?" /> }>
        <Switch {...register('isActive')} />
      </FormGroup>

      <FormGroup label={ <InputLabel label="Czy wymaga webhook?" /> }>
        <Switch {...register('isRequireWebhook')} />
      </FormGroup>
    </FormSection>
  )
}






export default PaymentMethodInformationSection;
