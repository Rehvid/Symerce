const SettingInputTypeRawTextarea = ({register}) => {
  return (
    <textarea {...register('value')} className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light" />
  )
}

export default SettingInputTypeRawTextarea;
