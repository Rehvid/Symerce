import React, { useState } from 'react';
import { normalizeFiles } from '@admin/utils/helper';
import { UploadFileInterface } from '@admin/shared/interfaces/UploadFileInterface';
import { useDropzoneLogic } from '@admin/hooks/useDropzoneLogic';
import FormSection from '@admin/shared/components/form/FormSection';
import { hasAnyFieldError } from '@admin/shared/utils/formUtils';
import FormGroup from '@admin/shared/components/form/FormGroup';
import InputLabel from '@admin/shared/components/form/input/InputLabel';
import Dropzone from '@admin/components/form/dropzone/Dropzone';
import DropzoneThumbnail from '@admin/components/form/dropzone/DropzoneThumbnail';
import InputField from '@admin/shared/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/utils/validationRules';
import Switch from '@admin/shared/components/form/input/Switch';
import { DynamicFields } from '@admin/shared/components/form/DynamicFields';
import CurrencyIcon from '@/images/icons/currency.svg';
import { useData } from '@admin/hooks/useData';

const CarrierFormBody = ({register, fieldErrors, setValue, formData, watch, control}) => {
  const { currency } = useData();
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

      <FormGroup
        label={ <InputLabel label="Zintegrowany przewoźnik (API)?" /> }
      >
        <Switch {...register('isExternal')} />
      </FormGroup>

      {watch().isExternal && (
        <FormGroup label={ <InputLabel label="Informacje dla zintegrowanego przewoźnika" /> } >
          <DynamicFields
            name="externalData"
            control={control}
            register={register}
            renderItem={(index, namePrefix) => (
              <div className="space-y-2 flex flex-col gap-4">
                <InputField
                  {...register(`${namePrefix}.key`, {
                    ...validationRules.required(),
                  })}
                  placeholder="Klucz konfiguracji"
                  type="text"
                  hasError={!!fieldErrors?.config?.[index]?.key}
                  errorMessage={fieldErrors?.config?.[index]?.key?.message}
                />
                <InputField
                  {...register(`${namePrefix}.value`, {
                    ...validationRules.required(),
                  })}
                  placeholder="Wartość konfiguracji"
                  type="text"
                  hasError={!!fieldErrors?.config?.[index]?.value}
                  errorMessage={fieldErrors?.config?.[index]?.value?.message}
                />
              </div>
            )}
          />
        </FormGroup>
      )}

    </FormSection>
  )
}

export default CarrierFormBody;
