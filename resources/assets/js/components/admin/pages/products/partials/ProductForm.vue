<template>
	<div>
		<!--escuto o evento submit-->
		<form class="form" @submit.prevent="onSubmit">

			<div :class="['form-group', {'has-error': errors.image}]">
				<div v-if="errors.image">{{ errors.image[0] }}</div>
				<!--aqui deixo a pré visualização de imagem, se for null eu pré visualizo a imagem-->
				<div v-if="imagePreview" class="text-center">
					<img :src="imagePreview" class="image-preview">
					<button @click.prevent="removePreviewImage" class="btn btn-danger">Remover</button>
				</div>
				<div v-else>
					<!--criamos uma chamada para carregar a imagem @change=""-->
				<input type="file" class="form-control" @change="onFileChange">
				</div>
			</div>


			<!-- usando has podemos formatar o css-->
			<div :class="['form-group', {'has-error': errors.name}]">
				<!--no console do browse tenho o name que recebe o array que tem as propriedades do campo name que na posição zero tem o item que é a mensagem de erro faço um if para exibir a mensagem, ele mostra um erro de cadas vez, vamos pegar o da posição zero-->
				<div v-if="errors.name">{{ errors.name[0] }}</div>
				<input type="text" v-model="product.name" class="form-control" placeholder="Nome da produto">
			</div>

			

			<!-- usando has podemos formatar o css-->
			<div :class="['form-group', {'has-error': errors.description}]">
				<!--no console do browse tenho o name que recebe o array que tem as propriedades do campo name que na posição zero tem o item que é a mensagem de erro faço um if para exibir a mensagem, ele mostra um erro de cadas vez, vamos pegar o da posição zero-->
				<div v-if="errors.description">{{ errors.description[0] }}</div>
				<textarea v-model="product.description" cols="30" rows="10" class="form-control" placeholder="descrição do produto"></textarea>
			</div>

			<div :class="['form-group', {'has-error': errors.category_id}]">
				<div v-if="errors.category_id">{{ errors.category_id[0] }}</div>	
				<!--usando o data bind no select eu posso cadastrar um produto com uma categoria dinâmica-->				
				<select class="form-control" v-model="product.category_id">
					<!--crio uma propriedade computada-->
					<option value="">Selecione a categoria</option>
					<!--uso o for para listar, pego o category q é nossa propriedade computada-->
					<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
				</select>
			</div>

			<div class="form-group">
				<!--<button type="submit" class="btn btn-primary"  @click="prod(produto)">Enviar</button>

				this.$emit('nomeDoEvento', valorDaPropriedadeQueVaiEnviar)

				<button type="submit" class="btn btn-primary"  @click="$emit('product')">Enviar</button><button type="submit" class="btn btn-primary">Enviar</button>
				<button type="submit" class="btn btn-primary"  @click="callParent">Enviar</button>-->
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	//recebendo propriedade
	props: {
		//propriedade que informa se eu estou autorizando ou cadastrando
		update: {
			//ñ preciso informar
			require: false,
			//tipo booleano
			type: Boolean,
			//aqui mostra que o evento padrão está cadastrando e não editando 
			default: false
		},
		product: {
			//requered é usado para definir que aquela propriedade deve ser recebida, isto é ela é obrigatória 
			require: false,
			//type é usado para garantir que somente aquele tipo de dado será passado para o componente. é altamente recomendado usá-lo para evitar side-effects. Ele aceita os seguintes tipos: string, number, boolean, function, obejct, array e symbol
			type: Object
			/*default é usado para definirmos um valor padrão para aquela propriedade, caso a prop seja inexistente
			default: () => {
				return {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				}
			}*/
		}
	},
	data () {
		return {
			errors: {},
			//com valor de null ou vazio, tanto faz
			upload: null,
			imagePreview: null,

		}
	},
	computed: {
		categories () {
			//pego todos esses dados para manipulá-los e faço um array com o data pra listar nossas categoias
			return this.$store.state.categories.items.data
		}
	},
	methods: {
		onSubmit () {
			//se quisermos atualizar então updateProduct se não storeProduct
			let action = this.update ? 'updateProduct' : 'storeProduct'

			//para o upload de imagem uso a classe FormData()
			//armazeno essa classa na constante
			const formData = new FormData()
			//aqui disponho de alguns métodos para o envio
			//como a imagem é opcional faço uma condição
			if (this.upload != null) 
				formData.append('image', this.upload)


			formData.append('id', this.product.id)
			formData.append('name', this.product.name)
			formData.append('description', this.product.description)
			formData.append('category_id', this.product.category_id)


			//this.product fará o two-way-data-bind, conforme for digitando os valores ele vai atualizando o product:{}
			//this.$store.dispatch('storeProduct', this.product)

			//agora vamos deixar mais genérico essa ordem 
			//this.$store.dispatch(action, this.product)
			//posso substituir product por formData que tem o mesmo resultado
			this.$store.dispatch(action, formData)//e vamos para a action.js
			//agora criar uma action para gravar produto
					.then(() => {
						this.$snotify.success('Sucesso ao Enviar')

						//chamando o método reset () {}
						this.reset ()
						//confirmando que está ok
						//vou no coponent que despara lá em ProductComponent
						this.$emit('success')
						//this.$emit('resetProduct', this.product)
					})
					.catch(errors => {
						this.$snotify.error('Algo está Errado', 'Erro')

						this.errors = errors.data.errors
					})
		},
		//método para resetar o errors do formulário modal
		reset () {
			this.errors = {}
			/*esse product é da propriedade computada
			this.product = {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				}
			*/
			//para resetar a model do upload/imagem
			this.upload = null
			this.imagePreview = null
		},
		//pegamos a variável e que é um parâmetro por padrão, que a partir dele vamos conseguir capturar os valores que vamos fazer um upload
		onFileChange (e) {
			// o e pegar a propriedade target que pega a propriedade files que é a referência do campo, a variável files vai receber esse valores ou || posso receber e.data.Transfer...
			let files = e.target.files || e.dataTransfer.files
			//se não receber nada retorne
			if (!files.length)
				return
 			//retorna váriios arquivos, um array, vamos no data e criamos o upload
 			this.upload = files[0]
 			//chamo o método previewImage no index [0] q é o primeiro arquivo
 			this.previewImage(files[0])
		},

		//mpetodo para pre visualização
		previewImage (file) {
			//vou precisar da classe do javascript FileReader()
			//armazeno o objeto e uma var q através dele eu vou usar um caminho temporário para visualizá-la
			let reader = new FileReader()
			//pego a var reader q pega a propriedade onload que recebe um callback q passa para ela como parâmetro o (e) que é o proprio objeto da imagem 
			reader.onload = (e) => {
				//aqui faço algumas configurações
				//com o (e) consigo pegar com o target a imagem e armazeno em algum lugar para fazer esse pre visualização, para isso vou no data e crio uma propriedade com o nome de imagePreview que vai receber a imagem
				this.imagePreview = e.target.result 

			}
			//uso esse método e passo a imagem
			reader.readAsDataURL(file)
			//por fim chamo todo esse método no onFileChange
		},
//esse métódo remove o upload
		removePreviewImage () {
			//pego a propriedade imagePreview e passo para null
			this.imagePreview = null
			this.upload = null
		}
	}
}
	
</script>

<style scoped>
	.image-preview{max-width: 60px;}
</style>