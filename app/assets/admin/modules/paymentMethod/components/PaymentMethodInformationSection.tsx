import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Description from '@admin/common/components/Description';
import CurrencyIcon from '@/images/icons/currency.svg';
import Switch from '@admin/common/components/form/input/Switch';
import React, { useState } from 'react';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import { normalizeFiles } from '@admin/common/utils/helper';
import { useDropzoneLogic } from '@admin/common/hooks/form/useDropzoneLogic';
import { UploadFileInterface } from '@admin/common/interfaces/UploadFileInterface';
import { useAppData } from '@admin/common/context/AppDataContext';

const PaymentMethodInformationSection = ({register, fieldErrors, formData, setValue}) => {
  const { currency } = useAppData();
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
