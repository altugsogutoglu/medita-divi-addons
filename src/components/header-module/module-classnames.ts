import { ModuleClassnamesParams, textOptionsClassnames } from '@divi/module';
import { HeaderModuleAttrs } from './types';

export const moduleClassnames = ({
  classnamesInstance,
  attrs,
}: ModuleClassnamesParams<HeaderModuleAttrs>): void => {
  // Text Options.
  classnamesInstance.add(textOptionsClassnames(attrs?.module?.advanced?.text));
};
