.class Lcom/airbnb/lottie/bf$3;
.super Ljava/lang/Object;

# interfaces
.implements Lcom/airbnb/lottie/n$a;


# annotations
.annotation system Ldalvik/annotation/EnclosingClass;
    value = Lcom/airbnb/lottie/bf;
.end annotation

.annotation system Ldalvik/annotation/InnerClass;
    accessFlags = 0x0
    name = null
.end annotation

.annotation system Ldalvik/annotation/Signature;
    value = {
        "Ljava/lang/Object;",
        "Lcom/airbnb/lottie/n$a",
        "<",
        "Ljava/lang/Integer;",
        ">;"
    }
.end annotation


# instance fields
.field final synthetic a:Lcom/airbnb/lottie/bf;


# direct methods
.method constructor <init>(Lcom/airbnb/lottie/bf;)V
    .locals 0

    iput-object p1, p0, Lcom/airbnb/lottie/bf$3;->a:Lcom/airbnb/lottie/bf;

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    return-void
.end method


# virtual methods
.method public a(Ljava/lang/Integer;)V
    .locals 1

    iget-object v0, p0, Lcom/airbnb/lottie/bf$3;->a:Lcom/airbnb/lottie/bf;

    invoke-static {v0}, Lcom/airbnb/lottie/bf;->a(Lcom/airbnb/lottie/bf;)V

    return-void
.end method

.method public bridge synthetic a(Ljava/lang/Object;)V
    .locals 0

    check-cast p1, Ljava/lang/Integer;

    invoke-virtual {p0, p1}, Lcom/airbnb/lottie/bf$3;->a(Ljava/lang/Integer;)V

    return-void
.end method
