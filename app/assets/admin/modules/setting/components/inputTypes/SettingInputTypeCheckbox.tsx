import Switch from '@admin/shared/components/form/input/Switch';

const SettingInputTypeCheckbox = ({register}) => {
  return (
    <Switch {...register('value')} />
  )
}

export default SettingInputTypeCheckbox;
