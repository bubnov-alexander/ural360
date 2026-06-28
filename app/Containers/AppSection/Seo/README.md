# SEO

Контейнер переносит базовую SEO-логику из проекта `vmm-nt-ru`.

Внутри:

- polymorphic-модель `Seo`;
- trait и contract для моделей с SEO;
- service для генерации meta/open graph/json-ld через `artesaos/seotools`;
- Filament-компонент вкладки SEO.
